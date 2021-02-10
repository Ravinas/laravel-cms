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
use Illuminate\Support\Facades\Hash;

class ActionsController extends Controller
{

    public function __construct()
    {

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

    public function save(Request $request)
    {
        $rules = [
          'email' => 'required|email'
        ];
        dd($request->post('email'));
        $valid = Validator::make($request->all(),$rules);
        if($valid->fails()){
            return response(['status' => 'error' , 'response' => trans('cms::panel.ebulletins.error.bad_email')]);
        } else {
            // bu dil ve email ile kayitli mi
            // kayitli ve aktif değilse tekrar aktivasyon maili yollar
            // kayitli değilse kayit yapar ve aktivasyon maili yollar
            $ebulletin = Ebulletin::where('email',$request->post('email'))
                ->where('lang_id',$request->post('lang_id'))
                ->first();
            if($ebulletin){
                if($ebulletin->status == 1){
                    return response(['status' => 'error' , 'response' => trans('cms::panel.ebulletins.error.registered')]);
                }
            } else {
                $ebulletin = new Ebulletin();
                $ebulletin->lang_id = $request->post('lang_id');
                $ebulletin->email = $request->post('email');
                $ebulletin->status = 0;
                $ebulletin->activate_token = base64_encode(Hash::make($request->post('email')));
                $ebulletin->save();

                //aktivasyon için mail
                $locale = Language::find($request->post('lang_id'));
                Mail::to($ebulletin->email)->locale($locale->code)->send(new EbulletinMail($ebulletin,'activation'));

                return response(['status'=>'success' , 'response' => trans('cms::panel.ebulletins.success.registered')]);
            }

        }
    }
}
