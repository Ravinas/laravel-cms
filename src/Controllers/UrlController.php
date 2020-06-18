<?php

namespace CMS\Controllers;

use CMS\Models\Language;
use CMS\Models\PageDetail;
use CMS\Models\Redirect;
use Illuminate\Http\Request;
use function Couchbase\defaultDecoder;

class UrlController extends Controller
{
    private $key ;
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
            app()->currentLanguage = Language::where('code',app()->getLocale())->first();

            //search var mı
            if($page->type == 3){
                return $this->search($request);
            }
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


        } elseif($request->path() == '/'){
            $homepage = PageDetail::where('lang_id',app()->currentLanguage->id)
                ->where('status',1)
                ->whereHas('page',function($q){
                $q->where('type',2)
                    ->where('status',1);
            })->first();
            if($homepage){
                return redirect($homepage->url);
            } else {
                $anypage = PageDetail::where('lang_id',app()->currentLanguage->id)->where('status',1)->first();
                return redirect($anypage->url);
            }

        }
        else {
            abort(404);
        }

    }

    public function search(Request $request){
        $this->key = $request->get("k");
        if($this->key){
            $searchResults = PageDetail::where('lang_id',app()->currentLanguage->id)
                ->where('status',1)
                ->where(function($q){
                    $q->where('name','LIKE','%'.$this->key.'%')
                        ->orWhere('content','LIKE','%'.$this->key.'%');
                })
                ->get();
            $detailExtraSearch = PageDetail::join('detail_extras','detail_extras.page_detail_id','page_details.id')
                ->where('page_details.status',1)
                ->where('page_details.lang_id',app()->currentLanguage->id)
                ->where('detail_extras.value','LIKE','%'.$this->key.'%')
                ->select('page_details.*')
                ->get();
            $extraSearch = PageDetail::join('extras','extras.page_id','page_details.page_id')
                ->where('page_details.status',1)
                ->where('page_details.lang_id',app()->currentLanguage->id)
                ->where('extras.value','LIKE','%'.$this->key.'%')
                ->select('page_details.*')
                ->get();
            $searchResults = $searchResults->merge($extraSearch);
            $searchResults = $searchResults->merge($detailExtraSearch);
            $searchResults = $searchResults->unique();
            $searchResults = $searchResults->forPage(1,1);

            $page = app()->page;
            app()->searchResults = $searchResults;
        } else {
            $searchResults = -1;
            $page = app()->page;
            app()->searchResults = $searchResults;
        }
        return view(app()->page->view,compact('page','searchResults'));

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
