<?php

namespace CMS\Controllers;
use CMS\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $logs = Log::paginate(25);
       // dd($logs->first());
        return view('cms::panel.log.index',compact('logs'));
    }
}
