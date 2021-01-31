<?php

namespace CMS\Controllers;

use CMS\Models\Language;
use CMS\Models\Slider;
use CMS\Models\SliderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use CMS\Traits\LogAgent;
use Auth;

class SliderController extends Controller
{
    use LogAgent;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lang = Language::where('status',1)->get();
        $slider = Slider::all();
        return view('cms::panel.slider.index',compact('slider','lang'));
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
        $check_name = Slider::where('name',$request->name)->first();
        if($check_name)
        {
            return response()->json([
                'Message'=>'Error',
                'Error' => 'Bu isimde bir slider zaten var!'
            ],200);
        }

        $slider = new Slider();
        $slider->name = $request->name;
        $slider->lang_id = $request->lang;
        $slider->status = 1;
        $slider->slug = Str::slug($request->name,'-');
        $slider->save();
        $this->createLog($slider,Auth::user()->id,"C");
        return response()->json(['Message'=>'Ok'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        $images = SliderItems::where('slider_id',$slider->id)->get();
        return view('cms::panel.slider.new-images',compact('images','slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        $this->createLog($slider,Auth::user()->id,"D");
        return response()->json(['Message'=>'Ok'],200);
    }

    public function addImage(Request $request)
    {
        $item = new SliderItems();
        $item->slider_id = $request->slider;
        $item->status = 1;
        $item->order = 0;
        $item->filepath = $request->filepath ?? 0;
        $item->general_text = $request->general_text;
        $item->sub_text = $request->sub_text;
        $item->sub_text2  = $request->sub_text2;
        $item->save();

        $this->createLog($item,Auth::user()->id,"C");

        return response()->json(['Message'=>'Ok']);
    }

    public function deleteImage(Request $request)
    {
        SliderItems::where('id',$request->image)->delete();
        $this->createLog(SliderItems::class,Auth::user()->id,"D");
        return response()->json(['Message' => 'Ok'],200);
    }

    public function getSliderImage(Request $request)
    {
        $slider_item = SliderItems::find($request->id);
        if ($slider_item)
        {
            return response()->json(['Message' => 'Ok','Slider' => $slider_item],200);
        }
    }

    public function editImage(Request $request)
    {
        $item = SliderItems::find($request->data["id"]);
        $item->status = 1;
        $item->filepath = $request->data["filepath"] ?? 0;
        $item->general_text = $request->data["general_text"];
        $item->sub_text = $request->data["sub_text"];
        $item->sub_text2 = $request->data["sub_text2"];
        $item->save();
        $this->createLog($item,Auth::user()->id,"U");

        return response()->json(['Message'=>'Ok']);
    }

    public function sortImage(Request $request)
    {
        $sort = $request->sort;
        parse_str($sort,$arr);
        $order = 1;
        foreach($arr['sliderItem'] as $id => $parent_id)
        {
            $slider_item = SliderItems::where('id',$id)->first();
            $slider_item->order = $order;
            $slider_item->save();
            $order++;
        }
        $this->createLog($slider_item,Auth::user()->id,"U");
        return response(['Message' => 'Ok'],200);
    }

}
