<?php

namespace CMS\Controllers;


use CMS\Facades\GoogleAnalytics;
use CMS\Models\Form;
use CMS\Traits\LogAgent;
use Illuminate\Http\Request;
use CMS\Models\Messages;
use Auth;
use CMS\Models\Message;

class HomeController extends Controller
{
    use LogAgent;
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

        $logs = $this->getLogs();
        $messages = Message::where('read',0)->paginate(5);
        return view('cms::panel.index',compact('messages','logs'));
    }
}
