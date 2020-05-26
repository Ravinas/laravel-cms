<?php

namespace CMS\Controllers;

use CMS\Facades\LanguageFacade;
use CMS\Models\DetailExtra;
use CMS\Models\Extra;
use CMS\Models\File;
use CMS\Models\Page;
use CMS\Models\Category;
use CMS\Models\PageDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Page::class);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::join('page_details','pages.id','=','page_details.page_id')
            ->where('pages.page_id',0)
            ->where('page_details.lang_id' , LanguageFacade::default())
            ->orderBy('pages.id')
            ->select('pages.*','page_details.name','page_details.url')
            ->get();
        return view('cms::panel.page.index',compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type=0;
        $parent = null;
        $order = null;
        $categories = null;

        if ($request->get('type') == 'dynamic')
        {
            $categories = Category::all();
            $type = 1;
            $parent = Page::where('id',$request->get('page'))->with('detail')->first();
            $max_order = Page::where('page_id',$parent->id)->where('status',1)->max('order');
            $order = $max_order +1;
        }

        return view('cms::panel.page.create',compact('type','parent','order','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check_url = PageDetail::whereIn('url',$request->post('url'))->first();
        if ($check_url)
        {
            return redirect()->route('pages.create')->with('error' ,$check_url->lang_id)->withInput();
        }

        if ($request->has('order'))
        {
            $this->checkOrder($request->post('page_id'),$request->post('order'));
        }

        $page = new Page();
        $page->page_id = $request->post('page_id') ?? 0;
        $page->order = $request->post('order') ?? 0;
        $page->status = $request->post('status');
        $page->type = $request->post('type') ?? 2;
        $page->save();
        if ($request->has('category')) {
            foreach ($request->category as $ct) {
                $page->categories()->attach($ct);
            }
        }

     //   fopen( resource_path( 'views/panel/page/extras'.$page->id.'.blade.php' ), 'w' );

        foreach(LanguageFacade::all() as $l){

            $this->storePageDetail($request, $page->id, $l);
        }
        return redirect()->route('pages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \CMS\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return view('cms::panel.page.show',compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CMS\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $include = false;

        if(View::exists('panel.extras.page'.$page->id.'.main')){
            $include = "panel.extras.page".$page->id.".main";
        } elseif($page->page_id && View::exists('panel.extras.page'.$page->page_id.'.sub')){
            $include = "panel.extras.page".$page->page_id.".sub";
        }
        $files = File::all();
        $categories = Category::all();
        $page_categories = $page->categories->pluck('id')->toArray();
        $pageDetails = PageDetail::where("page_id",$page->id)->with(['files','extras','language' => function($language){
            $language->where('status','1');
        }])->get();

        //urllerden tr/ en/ varsa at
        foreach($pageDetails as $pd){
            if(mb_substr($pd->url, 0, 3) == $pd->language->code."/"){
                $pd->url = substr($pd->url, 3);
            }
        }

        return view('cms::panel.page.edit',compact('page','pageDetails','include','files','categories','page_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \CMS\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $order_check = null;

        if ($request->has('order') && $request->post('page_id') )
        {
            if (!$this->updateOrder($request->post('page_id'),$request->post('order'),$page))
            {
                return back()->with('Message','Order');
            }

        }

        if ($request->has('category')) {
            $pc = $page->categories->pluck('id')->toArray();
            $delete_pivot = array_diff($pc, $request->category);
            foreach ($delete_pivot as $value) {
                 $page->categories()->wherePivot('category_id','=',$value)->detach();
            }

            foreach ($request->category as $ct) {
                $pg = Page::whereHas('categories',function($query) use ($ct){
                    $query->where('category_id',$ct);
                })->first();
                if ($pg) {
                   $page->categories()->wherePivot('category_id','=',$ct)->detach();
                }
                $page->categories()->attach($ct);
            }

        }
        if ($request->has('detail_extras'))
        {
            $this->checkDetailExtra($request->detail_extras);
        }

        if ($request->has('extras'))
        {
            $this->checkExtra($request->extras,$page->id);
        }

        if ($request->hasFile('detail_picture')) {
            $images = $request->file('detail_picture');
            $values = $request->post('detail_picture');
            foreach ($images as $detail_id => $image)
            {
                $filecontroller = new FileController();
                $filecontroller->validateImageFile($image);
                $filecontroller->store($image, $values[$detail_id]['file_name'],$detail_id,null,$values[$detail_id]['file_key']);
            }
        }

        if ($request->hasFile('picture')) {
            $images = $request->file('picture');
            $values = $request->post('picture');
            foreach ($images as $key => $image)
            {
                $filecontroller = new FileController();
                $filecontroller->validateImageFile($image);
                $filecontroller->store($image, $values[$key]['file_name'],null,$page->id,$values[$key]['file_key']);
            }
        }


        if ($request->hasFile('pdf')) {
            $filecontroller = new FileController();
            $filecontroller->validateImageFile($request->pdf);
            $filecontroller->store($request->file('pdf'), $request->post('file_name'),null,$request->post('file_page_detail'));
        }

        $page->page_id = $request->post('page_id') ?? 0;
        $page->order = $request->post('order') ?? 0 ;
        $page->status = $request->post('status');
        $page->save();


        $allPageDetails = PageDetail::where('page_id',$page->id)->with(['language' => function($lang){
            $lang->where('status','1');
        }])->get();

        foreach($allPageDetails as $k => $pd){
            if ($pd->language)
            {
                $pd->name = $request->post('name')[$pd->lang_id];
                $pd->content = $request->post('content')[$pd->lang_id];
                $pd->url = $pd->language->code."/".$request->post('url')[$pd->lang_id];
                $pd->status = $request->post('detail_status')[$pd->lang_id] ?? 0;
                $pd->save();
            }


        }
        return redirect()->route('pages.edit', array('page' => $page));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \CMS\Models\Page $page
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('pages.index');
    }

    public function getPages(){
        return Page::orderBy('order','asc')->get();
    }

    public function storePageDetail(Request $request,$page_id , $lang_id){
        $pd = new PageDetail();
        $pd->page_id = $page_id;
        $pd->lang_id = $lang_id->id;
        $pd->name = $request->post('name')[$lang_id->id];
        $pd->content = $request->post('content')[$lang_id->id];
        $pd->url = $pd->language->code."/".$request->post('url')[$pd->lang_id];
        $pd->status = $request->post('detail_status')[$lang_id->id] ?? 0;
        $pd->save();
    }

    public function subPages($id)
    {
        $parent_id = $id;
        $sub_pages = Page::join('page_details','pages.id','=','page_details.page_id')
            ->where('pages.page_id',$parent_id)
            ->where('page_details.lang_id',LanguageFacade::default())
            ->select('pages.*','page_details.name','page_details.url')
            ->orderBy('order')
            ->get();
        return view('cms::panel.page.subpage',compact('sub_pages','parent_id'));
    }

    public function urlControl(Request $request)
    {
        $check_url = PageDetail::where('url',$request->post('url'))->first();
        if ($request->has('page_id'))
        {
            if ($check_url->id != $request->post('page_id'))
            {
                return response()->json(['Message' => 'This url already in use.' , 'Status' => 0]);
            }else
            {
                return response()->json(['Message' => 'This url is available!' , 'Status' => 1]);
            }
        }else
        {
            if ($check_url)
            {
                return response()->json(['Message' => 'This url already in use.' , 'Status' => 0]);
            }else
            {
                return response()->json(['Message' => 'This url is available!' , 'Status' => 1]);
            }
        }

    }

    public function checkOrder($parent_id,$order)
    {
        $max_order = Page::where('page_id',$parent_id)->where('status',1)->max('order');
        if ($order > $max_order)
        {
            return false;
        }

        return true;
    }

    public function updateOrder($parent_id,$order,$page)
    {
        if ($this->checkOrder($parent_id,$order))
        {
            $pg = Page::where('order','>=',$order)->where('page_id',$parent_id)->where('id','!=',$page->id)->get();
            foreach ($pg as $p)
            {
                $p->order = $p->order + 1;
                $p->save();
            }

            return true;
        }
        return false;
    }

    public function checkDetailExtra($request)
    {
        $d_extras = $request;
        foreach ($d_extras as $detail_id => $dex) {
            foreach ($dex as $key => $d)
            {
                $found = DetailExtra::where('page_detail_id',$detail_id)->where('key',$key)->first();
                if ($found)
                {
                    $found->value = $d;
                    $found->save();
                }else
                {
                    if($d){
                        $de = new DetailExtra();
                        $de->page_detail_id = $detail_id;
                        $de->key = $key;
                        $de->value = $d;
                        $de->save();
                    }

                }
            }
        }
    }

    public function checkExtra($request,$page_id)
    {
        foreach ($request as $key => $value)
        {
            $found = Extra::where('page_id',$page_id)->where('key',$key)->first();
            if ($found)
            {
                $found->value = $value;
                $found->save();
            }else
            {
                $ex = new Extra();
                $ex->page_id = $page_id;
                $ex->key = $key;
                $ex->value = $value;
                $ex->save();
            }
        }
    }

}
