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

    protected $lang_extensions_visibility = [ 1 => "Open",  0 => "Close"];

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
        $langs = Language::orderBy('default','desc')->orderBy('status','desc')->orderBy('name')->get();
        $langs->default_language = $langs->where('default',1)->first();
        $reverse_key = "1";
        if(app()->showDefaultLanguageCode == "1")
        {
            $reverse_key = 0;
        }
        $langs->extensions = [
            "key" => $reverse_key,
            "text" => $this->lang_extensions_visibility[app()->showDefaultLanguageCode]
        ];
        return view('cms::panel.language.n-index',compact('langs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Language $language)
    {

    }

    public function updateList(Request $request)
    {

      $language = Language::find($request->id);
      if($language->default)
      {
        return response()->json([
            'Message' => 'Varsayılan dili kapatmaya çalıştınız',
            'Status' => $language->status
          ],403);
      }
      if($language->status)
      {
        $language->status = 0;
      }else{
        $language->status = 1;
      }
      $language->save();

      return response()->json([
          'Message' => 'Ok',
          'Status' => $language->status
        ],200);

    }


    public function changeDefaultLanguage(Request $request)
    {
        $default_language = Language::where('default',1)->get();

    }

    public function extensions(Request $request)
    {

        app()->showDefaultLanguageCode = $request->choosen;
        $this->lang_extensions_visibility = [
            "key" =>app()->showDefaultLanguageCode,
            "text" => $this->lang_extensions_visibility[app()->showDefaultLanguageCode]
        ];

        if(app()->showDefaultLanguageCode)
        {

            PageDetail::where('lang_id',app()->defaultLanguage->id)->where('url','NOT LIKE',app()->defaultLanguage->code.'/%')->where('url','!=',app()->defaultLanguage->code)->where('url','!=','/')->update(['url'=> DB::raw("CONCAT('".app()->defaultLanguage->code."/', `url`)")]);
            // dil kodu gözükmeyen dilin anasayfasını tr en şeklinde kaydet
            PageDetail::where('lang_id',app()->defaultLanguage->id)->where('url','/')->update(['url'=> app()->defaultLanguage->code]);

        }

        if(!app()->showDefaultLanguageCode){

            // DEFAULT DİLİN DİL KODU GÖZÜKMEYECEKSE DİL KODU OLAN TÜM URLLERİN İLK 3 KARAKTERİNİ TRAŞLA
            PageDetail::where('lang_id',app()->defaultLanguage->id)->where('url','LIKE',app()->defaultLanguage->code.'/%')->update(['url'=> DB::raw("SUBSTRING(`url`, 4)")]);
            // tr en şeklinde olan sayfaları / olarak kaydet
            PageDetail::where('lang_id',app()->defaultLanguage->id)->where('url',app()->defaultLanguage->code)->update(['url'=> '/']);
        }

        return response()->json([
            'Message' => 'Ok',
            'Code' => $this->lang_extensions_visibility["key"],
            'Text' => $this->lang_extensions_visibility["text"]
          ],200);

    }
}
