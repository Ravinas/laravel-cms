<?php

namespace CMS\Controllers;

use CMS\Models\Social;
use CMS\Controllers\Controller;
use Illuminate\Http\Request;
use CMS\Traits\LogAgent;
use Auth;
class SocialController extends Controller
{
    use LogAgent;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sm = Social::all();
        return view('cms::panel.socialmedia.index',compact('sm'));
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
        $order = $request->order;
        $max_order = Social::max('order');
        if ($order > $max_order + 1 || $order <= 0)
        {
            $order = $max_order + 1;
        }else
        {
           $ss = Social::where('order','>=',$order);
           foreach ($ss as $s)
           {
               $s->order = $s->order + 1;

           }
        }
        Social::updateOrCreate(['name' => $request->name],
        ['class' => $request->class,
            'url' => $request->url,
            'order' => $order]
        );
        $this->createLog(Social::class,Auth::user()->id,"C");
        return response(["Message" => "Ok"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Social::where('id',$id)->delete();
        $this->createLog(Social::class,Auth::user()->id,"D");
        return redirect()->route('socialmedia.index');
    }

    public function ajaxEdit(Request $request)
    {

        $social = Social::where('id',$request->id)->first();
        return response(["social" => $social]);

    }

    public function ajaxUpdate(Request $request)
    {
        $order = $request->order;
        $max_order = Social::max('order');
        if ($order > $max_order + 1 || $order <= 0)
        {
            $order = $max_order + 1;
        }else
        {
            $ss = Social::where('order','>=',$order);
            foreach ($ss as $s)
            {
                $s->order = $s->order + 1;

            }
        }
        $social = Social::find($request->id);
        $social->name = $request->name;
        $social->class =  $request->class;
        $social->url = $request->url;
        $social->order = $order;
        $social->save();
        $this->createLog($social,Auth::user()->id,"U");
        return response(["Message" => "Ok"]);
    }
}
