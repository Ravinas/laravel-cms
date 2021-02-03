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
        return view('cms::panel.language.index',compact('langs'));
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


    public function changeDefault(Request $request)
    {

        $old_default_language = Language::where('default',1)->first();
        $old_default_language->default = 0;
        $old_default_language->save();
        $this->refactorUrl($old_default_language);
        $default_language = Language::find($request->choosen);
        $default_language->default = 1;
        $default_language->status = 1;
        $default_language->save();
        $this->refactorUrl($default_language);

        return response()->json([
            'Message' => 'Ok'
          ],200);

    }

    public function extensions(Request $request)
    {

        app()->showDefaultLanguageCode = $request->choosen;
        $this->refactorUrl(app()->defaultLanguage);
        $this->lang_extensions_visibility = [
            "key" =>app()->showDefaultLanguageCode,
            "text" => $this->lang_extensions_visibility[app()->showDefaultLanguageCode]
        ];



        return response()->json([
            'Message' => 'Ok',
            'Code' => $this->lang_extensions_visibility["key"],
            'Text' => $this->lang_extensions_visibility["text"]
          ],200);

    }

    public function refactorUrl($language)
    {
        if($language->default)
        {
            if(app()->showDefaultLanguageCode)
            {

                PageDetail::where('lang_id',$language->id)->where('url','NOT LIKE',$language->code.'/%')->where('url','!=',$language->code)->where('url','!=','/')->update(['url'=> DB::raw("CONCAT('".$language->code."/', `url`)")]);
                PageDetail::where('lang_id',$language->id)->where('url','/')->update(['url'=> $language->code]);

            }else{

                PageDetail::where('lang_id',$language->id)->where('url','LIKE',$language->code.'/%')->update(['url'=> DB::raw("SUBSTRING(`url`, 4)")]);
                PageDetail::where('lang_id',$language->id)->where('url',$language->code)->update(['url'=> '/']);
            }
        }else{
                PageDetail::where('lang_id',$language->id)->where('url','NOT LIKE',$language->code.'/%')->where('url','!=',$language->code)->where('url','!=','/')->update(['url'=> DB::raw("CONCAT('".$language->code."/', `url`)")]);
                PageDetail::where('lang_id',$language->id)->where('url','/')->update(['url'=> $language->code]);
        }


    }
}
