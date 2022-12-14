<?php

namespace CMS\Controllers;

use CMS\Facades\LanguageFacade;
use CMS\Models\DetailExtra;
use CMS\Models\Extra;
use CMS\Models\File;
use CMS\Models\Language;
use CMS\Models\Meta;
use CMS\Models\Page;
use CMS\Models\Category;
use CMS\Models\PageDetail;
use CMS\Models\PagePermission;
use CMS\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use CMS\Traits\LogAgent;

class PageController extends Controller
{
    use LogAgent;
    private $options;
    public function __construct()
    {
        $this->authorizeResource(Page::class);
        //file
        Blade::directive('detailFile', function ($arguments) {
            list($label,$name,$key,$value,$id) = explode(',',$arguments);

            return '<div class="form-group">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <a id="'.$id.'" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                 '.$label.'
                                </a>
                            </span>
                            <input id="thumbnail" class="form-control" type="text" name="'.$name.'['.$key.']" value="'.$value.'">
                        </div>
                        <img id="holder" style="margin-top:15px;max-height:100px;">
                    </div>';
        });

        Blade::directive('file', function ($arguments) {
            list($label,$name,$value,$id) = explode(',',$arguments);

            return '<div class="form-group">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <a id="'.$id.'" data-input="thumbnail2" data-preview="holder2" class="btn btn-primary">
                                 '.$label.'
                                </a>
                            </span>
                            <input id="thumbnail2" class="form-control" type="text" name="'.$name.'" value="'.$value.'">
                        </div>
                        <img id="holder2" style="margin-top:15px;max-height:100px;">
                    </div>';
        });


        //text
        Blade::directive('text', function ($arguments) {
            list($label,$name,$key,$value) = explode(',',$arguments);
            return '<div class="form-group">
                        <label for="">'.$label.'</label>
                        <input type="text" class="form-control" name="extras['.$key.']" value="'.$value.'"/>
                    </div>';
        });



        //select

        //checkbox

        //radio

        $this->options ="";
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
        return $this->store($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = new Page();

        $roles = Role::where('id','>',2)->pluck('id');
        $page_permissions= [];

        if($request->get('page')){
            $page->page_id = $request->get('page');
            $page->type = 1;
            $max_order = Page::where('page_id',$request->get('page'))->max('order');
            $page->order = $max_order+1;
        } else {
            $page->page_id = 0;
            $page->type = 0;
            $page->order = 0;
        }

        $page->status = 0;
        $page->save();


        // rol olu??turulurken t??m sayfalar i??in yetki sat??r?? olu??turuluyor ama sonradan olu??turulan sayfalar??
        // yeni sayfa olu??turuldu??unda sonradan olu??turulan her rol i??in pagePermission yetki sat??r?? olu??tur.
        foreach($roles as $r){
            $page_permissions[] = [
                'role_id' => $r,
                'page_id' => $page->id,
                'permission' => 'C',
            ];
            $page_permissions[] = [
                'role_id' => $r,
                'page_id' => $page->id,
                'permission' => 'D',
            ];
        }
        PagePermission::insert($page_permissions);
        PagePermission::where('page_id',$page->id)->delete();

        $this->createLog($page,Auth::user()->id,"C");

        foreach(LanguageFacade::all() as $l){
            $this->createPageDetail($page->id,$l);
        }
        return redirect()->route('pages.edit',['page'=> $page]);

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
        if(!Auth::user()->hasPagePermission($page->id,'C')){
            return abort(403);
        }
        $detail_extra_include = false;
        $extra_include = false;
        if(View::exists('vendor.prime.extras.page'.$page->id.'detail-extra.main')){
            $detail_extra_include = "pages.page".$page->id.".main";
        } elseif($page->page_id && View::exists('vendor.prime.extras.page'.$page->page_id.'.detail-extra.page'.$page->id)){
            $detail_extra_include = "vendor.prime.extras.page".$page->page_id.'.detail-extra.page'.$page->id;
        }
        if ($page->page_id && View::exists('vendor.prime.extras.page'.$page->page_id.'.extras.page'.$page->id))
        {
            $extra_include = 'vendor.prime.extras.page'.$page->page_id.'.extras.page'.$page->id;

        }
        $files = File::all();
        $categories = Category::with('details')->get();
        $page_categories = $page->categories->pluck('id')->toArray();
        $languagesWithPageDetail = Language::join('page_details','languages.id','=','page_details.lang_id')
            ->where('languages.status',1)
            ->where('page_details.page_id',$page->id)
            ->pluck('page_details.lang_id')
            ->toArray();
        $languagesWithoutPageDetail = Language::where('status',1)
            ->whereNotIn('id',$languagesWithPageDetail)->pluck('id')->toArray();

        foreach($languagesWithoutPageDetail as $l){
            $newPageDetail = new PageDetail();
            $newPageDetail->page_id = $page->id;
            $newPageDetail->lang_id = $l;
            $newPageDetail->name = "";
            $newPageDetail->content = "";
            $newPageDetail->url = "auto_url_".$page->id."_".$l;
            $newPageDetail->status = 0;
            $newPageDetail->save();
            $this->createLog($newPageDetail,Auth::user()->id,"C");
            // sonradan a????lan dillerde meta eksik
            $newMeta = new Meta();
            $newMeta->page_detail_id = $newPageDetail->id;
            $newMeta->description = "";
            $newMeta->keywords = "";
            $newMeta->robots = 1;
            $newMeta->save();
            $this->createLog($newMeta,Auth::user()->id,"C");
        }

        $pageDetails = PageDetail::join('pages','pages.id','=','page_details.page_id')
            ->join('languages','languages.id','=','page_details.lang_id')
            ->where('languages.status' ,1)
            ->where('page_details.page_id',$page->id)
            ->select('page_details.*')
            ->get();
        //urllerden tr/ en/ varsa at
        foreach($pageDetails as $pd){
            $cond1 = app()->showDefaultLanguageCode;
            $cond2 = (app()->defaultLanguage->id == $pd->lang_id);
            if(!$cond1 && $cond2){
                $pd->showLanguageCode = false;
            } else {
                $pd->showLanguageCode = true;
            }
            if(mb_substr($pd->url, 0, 3) == $pd->language->code."/"){
                //urlin ilk 3 karakteri tr/ en/ ise editable k??s??mdan ????kar
                $pd->url = substr($pd->url, 3);
            } elseif (mb_substr($pd->url, 0, 2) == $pd->language->code){
                //urlin ilk 2 karakteri tr en ise dilin anasayfas??d??r heralde, host/en/ inputun solunda yazaca???? i??in bo?? g??nder
                $pd->url = "";
            } elseif($pd->url == "/"){
                // url sadece / ise default dil g??sterilmiyor ve anasayfad??r, host/tr/ inputun solunda yazaca???? i??in bo?? g??nder
                $pd->url = "";
            }

            $order = Page::where('page_id',$page->page_id)->max('order');
        }
        return view('cms::panel.page.edit',compact('page','pageDetails','detail_extra_include','extra_include','files','categories','page_categories','order'));
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
        if(!Auth::user()->hasPagePermission($page->id,'C')){
            return abort(403);
        }
        $order_check = null;
        if ($request->has('order') && $page->page_id) {
            $this->setOrders($request->post('order'),$page);
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
        if ($request->has('detail_extras')) {
            $this->checkDetailExtra($request->detail_extras);
        }

        if ($request->has('extras')) {
            $this->checkExtra($request->extras,$page->id);
        }

        if(Auth::user()->role_id == 1 && $request->has('type')){
            $page->type = $request->post('type');
        }
        $page->view = $request->post('view');
        $page->status = $request->post('status') ?? 0;
        $page->save();
        $this->createLog($page,Auth::user()->id,"U");


        $allPageDetails = PageDetail::where('page_id',$page->id)->with(['language' => function($lang){
            $lang->where('status','1');
        }])->get();

        foreach($allPageDetails as $k => $pd){
            if ($pd->language)
            {

                $pd->name = $request->post('name')[$pd->lang_id];
                $pd->content = $request->post('content')[$pd->lang_id];
                $cond1 = app()->showDefaultLanguageCode;
                $cond2 = app()->defaultLanguage->id == $pd->lang_id;
                if(!$cond1 && $cond2){

                    if($request->post('url')[$pd->lang_id] == null){
                        $pd->url = "/";
                    } else {
                        $pd->url = $request->post('url')[$pd->lang_id];
                    }
                } else {
                    if($request->post('url')[$pd->lang_id] == null){
                        $pd->url = $pd->language->code;
                    } else {
                        $pd->url = $pd->language->code."/".$request->post('url')[$pd->lang_id];
                    }

                }

                $pd->status = $request->post('detail_status')[$pd->lang_id] ?? 0;
                $pd->save();
                $this->createLog($pd,Auth::user()->id,"C");
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
        if(!Auth::user()->hasPagePermission($page->id,'D')){
            return abort(403);
        }
        $page->delete();
        $this->createLog($page,Auth::user()->id,"D");
        return redirect()->route('pages.index');
    }

    public function getPages(){
        return Page::orderBy('order','asc')->get();
    }

    public function createPageDetail($page_id , $language){
        $pd = new PageDetail();
        $pd->page_id = $page_id;
        $pd->lang_id = $language->id;
        $pd->name = $language->code."_auto_url_".$page_id;
        $pd->content = "";
        if($language->code == app()->defaultLanguage->code && app()->showDefaultLanguageCode == false){
            $pd->url = "auto_url_".$page_id;
        } else {
            $pd->url = $language->code."/auto_url_".$page_id;
        }

        $pd->status = 1;
        $pd->save();
        $this->createLog($pd,Auth::user()->id,"C");
        $meta = new Meta();
        $meta->page_detail_id = $pd->id;
        $meta->description = "";
        $meta->keywords = "";
        $meta->robots = 1;
        $meta->save();
        $this->createLog($meta,Auth::user()->id,"C");
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
        $parent = Page::find($parent_id);
        return view('cms::panel.page.subpage',compact('sub_pages','parent_id','parent'));
    }

    public function urlControl(Request $request)
    {
        $check_url = PageDetail::where('url',$request->post('url'))->first();


        if($check_url){
            if ($check_url->id != $request->post('page_id')) {
                return response()->json(['Status' => 0]);
            } else {
                return response()->json(['Status' => 1]);
            }
        } else {
            return response()->json([ 'Status' => 1]);
        }

    }

    public function setOrders($order,$page){
        $old_order = $page->order;

        $max_order = Page::where('page_id',$page->page_id)->where('id','!=',$page->id)->max('order');

        if ($order > $max_order) {
            $real_max = Page::where('page_id',$page->page_id)->max('order');
            if($real_max == $page->order){
                //kendisi zaten maxsa hi?? dokunma
            } else {
                //kendisi max de??il ve maxtan b??y??k order gelmi??se
                $order = $max_order+1;
                $page->order = $order;
                $page->save();
                Page::where('page_id',$page->page_id)
                    ->where('order','>',$old_order)->decrement('order');
            }
        } else {
            if($order > $old_order){
                Page::where('page_id',$page->page_id)
                    ->where('order','<=',$order)
                    ->where('order','>',$old_order)
                    ->decrement('order');
                $page->order = $order;
                $page->save();
            } else {
                Page::where('page_id',$page->page_id)
                    ->where('order','>=',$order)
                    ->where('order','<',$old_order)
                    ->increment('order');
                $page->order = $order;
                $page->save();
            }
        }
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
                        $this->createLog($de,Auth::user()->id,"U");
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
                if($value){
                    $ex = new Extra();
                    $ex->page_id = $page_id;
                    $ex->key = $key;
                    $ex->value = $value;
                    $ex->save();
                    $this->createLog($ex,Auth::user()->id,"U");
                }

            }
        }
    }

}
