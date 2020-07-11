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
        $slider = Slider::firstOrCreate(
            ['name' => $request->name,
              'lang_id' => $request->lang,
                'status' => 1,
                'slug' => Str::slug($request->name,'-')
                ]
        );
        $this->createLog(Slider::class,Auth::user()->id,"C");
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
        return view('cms::panel.slider.images',compact('images','slider'));
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
    }

    public function addImage(Request $request)
    {
        $slider_items = new SliderItems();
        $order = SliderItems::max('order');
        if ($order)
        {
            $slider_items->order = $order+1;
        }else{
            $slider_items->order = 1;
        }
        $slider_items->slider_id = $request->slider;
        $slider_items->status = 1;
        $slider_items->filepath = $request->filepath;
        $slider_items->general_text = $request->general_text;
        $slider_items->sub_text = $request->sub_text;
        $slider_items->sub_text2 = $request->sub_text2;
        $slider_items->save();
        $this->createLog($slider_items,Auth::user()->id,"C");

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
        $order = SliderItems::max('order');
        if ($request->data["order"] > $order)
        {
            $item->order = $order+1;
        }else{
            if ($request->data["order"] < 1)
            {
                $others = SliderItems::all();
                $item->order = 1;
                if ($others)
                {
                    foreach ($others as $other)
                    {
                        $other->order = $other->order + 1;
                        $other->save();
                    }
                }
            }else
            {
                $item->order = $request->data["order"];
                $others_order = SliderItems::where('order','>=',$request->data["order"])->get();
                foreach($others_order as $o)
                {
                    $o->order = $o->order + 1;
                    $o->save();
                }
            }
        }
        $item->status = 1;
        $item->filepath = $request->data["filepath"];
        $item->general_text = $request->data["general_text"];
        $item->sub_text = $request->data["sub_text"];
        $item->sub_text2 = $request->data["sub_text2"];
        $item->save();
        $this->createLog($item,Auth::user()->id,"U");

        return response()->json(['Message'=>'Ok']);
    }

}
