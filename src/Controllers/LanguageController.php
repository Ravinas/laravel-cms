<?php

namespace CMS\Controllers;


use CMS\Models\Ebulletin;
use CMS\Models\Language;
use CMS\Policies\BasePolicy;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Language::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $default_language = Language::where('status',1)->where('default',1)->first();
        $active_languages = Language::where('status',1)->where('default','!=',1)->get();
        $passive_languages = Language::where('status','!=',1)->get();
        return view('cms::panel.language.index',compact('default_language','active_languages','passive_languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Language $language)
    {

        $langs = Language::where("id" ,"!=",0);
        $langs->update(["status" => 0, "default" => 0]);

        if($request->def_lang_id){
            $default = $langs->find($request->def_lang_id);
            $default->status = 1;
            $default->default = 1;
            $default->save();
        }
        $langs = Language::where("id" ,"!=",0);
        $actives = $langs->whereIn("id",$request->langs);
        $actives->update(["status" => 1]);

//        dd($request->def_lang_id,$request->langs);
//        $active_languages = Language::where('status',1)->get();
//        foreach ($active_languages as $al)
//        {
//            if (!in_array($al->id,$request->act_langs))
//            {
//                $al->status = 0;
//                $al->save();
//            }
//
//        }
//        $new_active_langs = Language::whereIn('id',$request->act_langs)->get();
//        foreach ($new_active_langs as $nal)
//        {
//            $nal->status = 1;
//            $nal->save();
//        }
//
//        $default_language = Language::where('default',1)->first();
//        if(!$default_language){
//            $default_language = Language::find($request->def_lang_id);
//            if($default_language){
//                $default_language->default = 1;
//                $default_language->save();
//            }
//
//        }
//
//        if ($request->def_lang_id != $default_language->id)
//        {
//            $default_language->default = 0;
//            $default_language->save();
//            $new_default = Language::find($request->def_lang_id);
//            $new_default->default = 1;
//            $new_default->save();
//        }


        return redirect()->route('languages.index');
    }
}
