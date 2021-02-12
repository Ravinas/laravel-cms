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
            ->where('category_details.lang_id',app()->defaultLanguage->id)
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
        $category->status = $request->status ?? 0;
        $category->order = 0;
        $category->image =  $request->picture;
        $category->save();
        foreach (LanguageFacade::all() as $lang) {

            $this->storeDetail($category->id,$lang->id,$request);

        }
        $this->createLog($category,Auth::user()->id,"C");
        return response()->json(['Message' => 'Ok'],200);
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

    }

    public function customUpdate(Request $request)
    {

        $category = Category::find($request->edit_id);
        $category->parent_id = $request->edit_parent_id ?? 0;
        $category->status = $request->edit_status ?? 0;
        $category->image = $request->edit_picture;
        $category->save();

        foreach (app()->activeLanguages as $lang) {
            $detail = CategoryDetail::where('category_id',$category->id)->where('lang_id',$lang->id)->first();
            $detail->name = $request->edit_name[$lang->id];
            $detail->status = $request->edit_detail_status[$lang->id] ?? 0;
            $detail->slug = Str::slug($request->edit_name[$lang->id]);
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

    public function getCategory(Request $request)
    {
        $category = Category::with('details')->find($request->id);
        return response()->json(['Message' => 'Ok' , 'Data' => $category],200);
    }

    public function sortCategory(Request $request)
    {
        $sort = $request->sort;
        parse_str($sort,$arr);
        $order = 1;
        foreach($arr['categoryItem'] as $id => $parent_id)
        {

            $category = Category::where('id',$id)->first();
            $category->order = $order;
            if($parent_id == 'null')
            {
                $category->parent_id = 0;
            }else
            {
                $category->parent_id = $parent_id;
            }
            $category->save();
            $order++;
        }
        $this->createLog($category,Auth::user()->id,"U");
        return response(['Message' => 'Ok'],200);
    }


}
