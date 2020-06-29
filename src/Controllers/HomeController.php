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

        $messages = Message::where('read',0)->paginate(5);
        return view('cms::panel.index',compact('messages'));
    }
}
