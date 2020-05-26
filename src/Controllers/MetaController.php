<?php

namespace CMS\Controllers;

use CMS\Models\Meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MetaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Meta::class);
    }

    public function index()
    {
        $metas = Meta::join('page_details','metas.page_detail_id','=','page_details.id')
            ->join('pages','page_details.page_id','=','pages.id')
            ->select('pages.*','page_details.*','metas.*')
            ->get();
        return view('cms::panel.meta.index',compact('metas'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \CMS\Models\Meta  $meta
     * @return \Illuminate\Http\Response
     */
    public function show(Meta $meta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CMS\Models\Meta  $meta
     * @return \Illuminate\Http\Response
     */
    public function edit(Meta $meta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \CMS\Models\Meta  $meta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meta $meta)
    {
        $rules = [
            'description' => 'string|nullable|max:160',
            'keywords' => 'string|nullable|max:250',
            'robots' => 'nullable|integer'
        ];
        $valid = Validator::make($request->all(),$rules);
        if($valid->fails()) {
            return response('fail',406);
        } else {
            $meta = Meta::find($request->post('meta_id'));
            $meta->description = $request->post('description');
            $meta->keywords = $request->post('keywords');
            $meta->robots = $request->post('robots');
            $meta->save();
            return response('success',200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CMS\Models\Meta  $meta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meta $meta)
    {
        //
    }
}
