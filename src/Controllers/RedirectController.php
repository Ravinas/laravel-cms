<?php

namespace CMS\Controllers;

use CMS\Models\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RedirectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redirects = Redirect::where('from' ,'!=',null)->get();
        return view('cms::panel.redirect.index',compact('redirects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms::panel.redirect.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'from' => 'required',
            'to' => 'required',
            'code' => 'integer|nullable',
            'status' => 'integer',

        ];
        $valid = Validator::make($request->all(),$rules);
        if($valid->fails()){
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($valid);
        } else {
            $redirect = new Redirect();
            $redirect->from = $request->post('from');
            $redirect->to = $request->post('to');
            $redirect->code = $request->post('code');
            $redirect->status = $request->post('status');
            $redirect->save();
            return redirect()->route('redirects.index')->with(['type' => 'success', 'message' => 'redirect.created']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \CMS\Models\Redirect  $redirect
     * @return \Illuminate\Http\Response
     */
    public function show(Redirect $redirect)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CMS\Models\Redirect  $redirect
     * @return \Illuminate\Http\Response
     */
    public function edit(Redirect $redirect)
    {
        return view('cms::panel.redirect.edit',compact('redirect'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \CMS\Models\Redirect  $redirect
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Redirect $redirect)
    {
        $rules = [
            'from' => 'required',
            'to' => 'required',
            'code' => 'integer|nullable',
            'status' => 'integer',

        ];
        $valid = Validator::make($request->all(),$rules);
        if($valid->fails()){
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($valid);
        } else {
            $redirect->from = $request->post('from');
            $redirect->to = $request->post('to');
            $redirect->code = $request->post('code');
            $redirect->status = $request->post('status');
            $redirect->save();
            return redirect()->route('redirects.index')->with(['type' => 'success', 'message' => 'redirect.edited']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CMS\Models\Redirect  $redirect
     * @return \Illuminate\Http\Response
     */
    public function destroy(Redirect $redirect)
    {
        $redirect->delete();
        return redirect()->route('redirects.index')
            ->with('message',trans('cms::redirect.deleted'))
            ->with('type','danger');
    }
}
