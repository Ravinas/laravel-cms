<?php

namespace CMS\Controllers;

use CMS\Models\Ebulletin;
use CMS\Models\Language;
use CMS\Mail\EbulletinMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EbulletinController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Ebulletin::class);
    }
    // aktivasyon fonksiyonu
    public function activate($token){
        $ebulletin = Ebulletin::where('activate_token',$token)->first();
        if($ebulletin->status == 0){
            $ebulletin->status = 1;
            $ebulletin->save();

            //aktivasyon yapıldı maili
            $locale = Language::find($ebulletin->lang_id);
            Mail::to($ebulletin->email)->locale($locale->code)->send(new EbulletinMail($ebulletin,'activated'));

            // @TODO ebulletin önyüz bladeleri
            //return view('cms::panel.ebulletin.activated_now');
            dd("aktifleştirildi");

        } else {
            //return view('cms::panel.ebulletin.activated_before');
            dd("zaten aktifti");
        }
    }

    //üyelikten çıkma fonksiyonu
    public function cancel($token){
        $ebulletin = Ebulletin::where('activate_token',$token)->first();
        if($ebulletin->status == 1){
            $ebulletin->status = 0;
            $ebulletin->save();

            //abonelikten çıktınız maili
            $locale = Language::find($ebulletin->lang_id);
            Mail::to($ebulletin->email)->locale($locale->code)->send(new EbulletinMail($ebulletin,'cancelled'));

            // @TODO ebulletin önyüz bladeleri
            //return view('cms::panel.ebulletin.activated_now');
            dd("pasifleştirildi");

        } else {
            //return view('cms::panel.ebulletin.activated_before');
            dd("zaten pasifti");
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ebulletins = Ebulletin::join('languages','languages.id','=','ebulletins.lang_id')
            ->select('languages.name','ebulletins.*')
            ->orderBy('id','desc')
            ->paginate(15);
        return view('cms::panel.ebulletin.index',compact('ebulletins'));
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
        $rules = [
          'email' => 'required|email',
          'lang_id' => 'required|integer'
        ];
        $valid = Validator::make($request->all(),$rules);
        if($valid->fails()){
            return response(['response'=>$valid->getMessageBag()->toArray()],406);
        } else {
            // bu dil ve email ile kayitli mi
            // kayitli ve aktifse status 406 ile döner
            // kayitli ve aktif değilse tekrar aktivasyon maili yollar
            // kayitli değilse kayit yapar ve aktivasyon maili yollar
            $ebulletin = Ebulletin::where('email',$request->post('email'))
                ->where('lang_id',$request->post('lang_id'))
                ->first();
            if($ebulletin){
                if($ebulletin->status == 1){
                    return response(['response' => ['email' => trans('cms::ebulletin.already_registered')]], 406);
                }
            } else {
                $ebulletin = new Ebulletin();
                $ebulletin->lang_id = $request->post('lang_id');
                $ebulletin->email = $request->post('email');
                $ebulletin->status = 0;
                $ebulletin->activate_token = Str::random(32);
                $ebulletin->save();
            }

            //aktivasyon için mail
            $locale = Language::find($request->post('lang_id'));
            Mail::to($ebulletin->email)->locale($locale->code)->send(new EbulletinMail($ebulletin,'activation'));

            return response()->json(['response'=>'success']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \CMS\Models\Ebulletin  $ebulletin
     * @return \Illuminate\Http\Response
     */
    public function show(Ebulletin $ebulletin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CMS\Models\Ebulletin  $ebulletin
     * @return \Illuminate\Http\Response
     */
    public function edit(Ebulletin $ebulletin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \CMS\Models\Ebulletin  $ebulletin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ebulletin $ebulletin)
    {
        $rules = ['status'=>'required|boolean'];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CMS\Models\Ebulletin  $ebulletin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ebulletin $ebulletin)
    {
        //
    }
}
