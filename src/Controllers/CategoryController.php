<?php

namespace CMS\Controllers;

use CMS\Facades\LanguageFacade;
use CMS\Models\Category;
use CMS\Models\CategoryDetail;
use Illuminate\Http\Request;
use Str;
use CMS\Models\File;
use CMS\Traits\LogAgent;
use Auth;

class CategoryController extends Controller
{
    use LogAgent;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories = Category::join('category_details','categories.id','=','category_details.category_id')
        ->where('categories.parent_id',0)
        ->where('category_details.lang_id',LanguageFacade::default())
        ->select('categories.id','category_details.name')
        ->orderBy('order')
        ->get();
        return view('cms::panel.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $max_order = Category::where('parent_id',0)->max('order');
        $order = $max_order +1;
        $categories = Category::join('category_details','categories.id','=','category_details.category_id')
        ->where('category_details.lang_id',LanguageFacade::default())
        ->select('categories.id','category_details.name')
        ->get();
        $files = File::all();
        return view('cms::panel.category.create',compact('categories','files','order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->parent_id = $request->parent_id;
        $category->status = $request->status;
        $category->order = $request->order;
        if ($request->hasFile('picture')) {
            $file_controller = new FileController();
            $file_controller->validateImageFile($request->file('picture'));
            $category->image =  $file_controller->storeCategoryFile($request->file('picture'));
        }
        $category->save();
        $check_order = Category::where('order',$category->order)->where('parent_id',$category->parent_id)->first();
        if ($check_order) {
            $update_orders = Category::where('order','>=',$category->order)->where('parent_id',$category->parent_id)->where('id','!=',$category->id)->get();
            foreach ($update_orders as $category_order)
            {
                $category_order->order = $category_order->order + 1;
                $category_order->save();
            }
        }
        foreach (LanguageFacade::all() as $lang) {
            $this->storeDetail($category->id,$lang->id,$request);
        }

        $this->createLog($category,Auth::user()->id,"C");

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \CMS\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CMS\Models\Category  $category
     * @return \Illuminate\Http\Responseredirect()->route('')
     */
    public function edit(Category $category)
    {
        $categories = Category::join('category_details','categories.id','=','category_details.category_id')
        ->where('category_details.lang_id',LanguageFacade::default())
        ->select('categories.id','category_details.name')
        ->get();
        $orders = Category::where('parent_id',$category->parent_id)->select('order')->pluck('order')->toArray();
        $files = File::all();
        return view('cms::panel.category.edit',compact('categories','files','orders','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \CMS\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->parent_id = $request->parent_id;
        $category->status = $request->status;
        $category->order = $request->order ?? 0;
            if ($request->hasFile('picture')) {
                $file_controller = new FileController();
                $file_controller->validateImageFile($request->file('picture'));
                $category->image =  $file_controller->storeCategoryFile($request->file('picture'));
            }
        $category->save();
        $update_orders = Category::where('order','>=',$category->order)->where('parent_id',$category->parent_id)->where('id','=!',$category->id)->get();
            foreach ($update_orders as $category_order)
            {
                $category_order->order = $category_order->order + 1;
                $category_order->save();
            }

          
 
        foreach (app()->activeLanguages as $lang) {
             $detail = CategoryDetail::where('category_id',$category->id)->where('lang_id',$lang->id)->first();
             $detail->name = $request->name[$lang->id];
             $detail->slug = Str::slug($request->name[$lang->id]);
             $detail->save();
        }

        $this->createLog($category,Auth::user()->id,"U");
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CMS\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $cats = Category::where('parent_id',$category->parent_id)->where('order','>',$category->order)->get();
        foreach ($cats as $key => $cat) {
            $cat->order = $cat->order -1;
            $cat->save();
        }
        $category->delete();
        $this->createLog($category,Auth::user()->id,"D");
        return redirect()->route('categories.index');
    }

    public function storeDetail($category_id,$lang_id,$request)
    {
        $detail = new CategoryDetail();
        $detail->category_id = $category_id;
        $detail->lang_id = $lang_id;
        $detail->name = $request->post('name')[$lang_id];
        $detail->slug = Str::slug($request->post('name')[$lang_id]);
        $detail->status = $request->post('detail_status')[$lang_id];
        $detail->save();
        $this->createLog($detail,Auth::user()->id,"C");
    }

    public function order(Request $request)
    {
        $orders = Category::where('parent_id',$request->parent_id)->orderBy('order')->pluck('order')->toArray();
        if ($orders)
        {
           $orders = array_unique($orders);
            array_push($orders, max($orders) + 1);
        }else
        {
                $orders[] = 1;
        }
        return response()->json(["orders" => $orders]);

    }

}
