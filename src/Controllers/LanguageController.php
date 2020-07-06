<?php

namespace CMS\Controllers;


use CMS\Models\Ebulletin;
use CMS\Models\Language;
use CMS\Models\PageDetail;
use CMS\Policies\BasePolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use CMS\Traits\LogAgent;


class LanguageController extends Controller
{
    use LogAgent;
    
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
        $old_default = Language::where("default",1)->first();
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
        $active_langs = $actives;
        $actives->update(["status" => 1]);

        foreach($active_langs->get() as $lang){
            // DİL KODU OLMAYAN TÜM URLLERE DİL KODU EKLE
            PageDetail::where('lang_id',$lang->id)->where('url','NOT LIKE',$lang->code.'/%')->where('url','!=',$lang->code)->where('url','!=','/')->update(['url'=> DB::raw("CONCAT('".$lang->code."/', `url`)")]);
            // dil kodu gözükmeyen dilin anasayfasını tr en şeklinde kaydet
            PageDetail::where('lang_id',$lang->id)->where('url','/')->update(['url'=> $lang->code]);

        }
        if(!app()->showDefaultLanguageCode){
            // DEFAULT DİLİN DİL KODU GÖZÜKMEYECEKSE DİL KODU OLAN TÜM URLLERİN İLK 3 KARAKTERİNİ TRAŞLA
            PageDetail::where('lang_id',$default->id)->where('url','LIKE',$default->code.'/%')->update(['url'=> DB::raw("SUBSTRING(`url`, 4)")]);
            // tr en şeklinde olan sayfaları / olarak kaydet
            PageDetail::where('lang_id',$default->id)->where('url',$default->code)->update(['url'=> '/']);
        }

        $this->createLog($language,Auth::user()->id,"U");


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
