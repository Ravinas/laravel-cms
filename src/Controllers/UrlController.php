<?php

namespace CMS\Controllers;

use CMS\Models\Language;
use CMS\Models\PageDetail;
use CMS\Models\Redirect;
use Illuminate\Http\Request;
use function Couchbase\defaultDecoder;

class UrlController extends Controller
{
    public function url(Request $request)
    {
        $redirect = $this->hasRedirect($request);
        if( $redirect ){
            return redirect($redirect->to,$redirect->code ?? 301);
        }

        $url = $request->path();

        $pageDetail = PageDetail::where('url', $url)->where('status', 1)->first();
        if ($pageDetail) {

            if ($pageDetail->language->status != 1) {
                abort(404);
            } elseif ($pageDetail->page->status != 1) {
                abort(404);
            }

            $page = $pageDetail->page;
            app()->page = $page;
            app()->pageDetail = $pageDetail;
            app()->setLocale($pageDetail->language->code);

            // page->id ile main fonksiyon var mı
            if(method_exists ( 'App\Http\Controllers\Page'.$page->id.'Controller' , 'main')){
                return app('App\Http\Controllers\Page'.$page->id.'Controller')->main($request);
            }
            // page->page_id ile sub
            elseif(method_exists ( 'App\Http\Controllers\Page'.$page->page_id.'Controller' , 'sub'))
            {
                return app('App\Http\Controllers\Page'.$page->page_id.'Controller')->sub($request);

            } else{
                return view($page->view ?? 'cms::default', compact('page'));
            }


        } else {
            abort(404);
        }

    }

    public function hasRedirect(Request $request)
    {
        $full_url = url()->full();
        $path = $request->path();
        $url = $request->getRequestUri();

        $redirect = Redirect::whereIn('from',[$full_url,$path,$url])->where('status',1)->first();
        if($redirect){
            return $redirect;
        } else {
            return false;
        }
    }

}
