<?php

namespace CMS\Controllers;

use CMS\Models\Language;
use CMS\Models\Menu;
use CMS\Models\MenuItem;
use CMS\Models\PageDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use CMS\Traits\LogAgent;
use Auth;

class MenuController extends Controller
{
    use LogAgent;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = Menu::all();
        $lang = Language::where('status',1)->get();
        return view('cms::panel.menu.index',compact('menu','lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $menu = new Menu();
        $menu->name = $request->name;
        $menu->lang_id = $request->lang;
        $menu->status = 1;
        $menu->slug = Str::slug($request->name,'-');
        $menu->save();
        $this->createLog($menu,Auth::user()->id,"C");
        return response()->json(['Message'=>'Ok'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $urls = PageDetail::select('url')->get();
        $menu_items = MenuItem::where('parent_id', 0)->where('menu_id',$menu->id)->orderby('order')->get();
        return view('cms::panel.menu.items',compact('menu_items','menu','urls'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        if ($menu->items)
        {
            foreach ($menu->items as $item)
            {
                $item->delete();
            }
        }
        $menu->delete();
        $this->createLog($menu,Auth::user()->id,"D");
        return response()->json([
            'status' => 'Ok'
        ]);

      //  $this->createLog($menu,Auth::user()->id,"D");
      //  return redirect()->route('menu.index');
    }

    public function storeMenuItem(Request $request)
    {
        $item = new MenuItem();
        $item->menu_id = $request->menu_id;
        $item->parent_id = 0;
        $item->type = $request->type;
        $item->link_type = $request->link_type;
        $item->order = 99;
        $item->text = $request->text;
        $item->url = $request->link;
        $item->external = $request->external;
        $item->save();
        $this->createLog($item,Auth::user()->id,"C");
        return response()->json(['Message' => 'Ok'],200);
    }

    public function destroyMenuItem($menuitem)
    {
        $item = MenuItem::where('id',$menuitem)->first();
        $item->delete();
        return redirect()->route('menu.index');
    }

    public function ajax(Request $request)
    {
        $sort = $request->sort;
        parse_str($sort,$arr);
        $order = 1;

        foreach($arr['menuItem'] as $id => $parent_id)
        {
            $menu_item = MenuItem::where('id',$id)->first();
            $menu_item->order = $order;
            if($parent_id == 'null')
            {
                $menu_item->parent_id = 0;
            }else
            {
                $menu_item->parent_id = $parent_id;
            }
            $menu_item->save();
            $order++;
        }

        return response(['Message' => 'Ok'],200);
    }
}
