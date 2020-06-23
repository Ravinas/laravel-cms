<?php

namespace CMS\Controllers;


use CMS\Facades\GoogleAnalytics;
use CMS\Models\Form;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $forms = Form::with('messages')->get();
        return view('cms::panel.index',compact('forms'));
    }
}
