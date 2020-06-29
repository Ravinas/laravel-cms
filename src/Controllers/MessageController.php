<?php

namespace CMS\Controllers;

use CMS\Models\Form;
use CMS\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class MessageController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Message::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Form $form)
    {
        $messages = Message::where('form_id',$form->id)
            ->orderBy('created_at','desc')
            ->paginate(15);
        /*foreach($messages as $m){
            $decode = json_decode($m->data);
            $messages->email = $decode["email"];
        }*/
        return view('cms::panel.message.index',compact('messages','form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = Form::find($request->post('form_id'));
        $rules = json_decode($form->rules,true);
        $error_messages = json_decode($form->error_messages,true);
        $valid = Validator::make($request->all(),$rules,$error_messages);
        if($valid->fails()){
            return redirect()->back()
                ->withErrors($valid)
                ->withInput($request->all());
        } else {
            $message = new Message();
            $message->form_id = $form->id;
            $message->ip = $request->ip();
            foreach($rules as $k => $v){
                if($request->file($k)){
                    $request->file($k)->storePublicly("/public");
                    $inputs["f_".$k] = "/storage/".$request->file($k)->hashName();
                } elseif($request->post($k)){
                    $inputs[$k]=$request->post($k);
                } else {
                    $inputs[$k]="form_no_input";
                }
            }
            $message->data = json_encode($inputs);
            $message->save();
            return redirect()->back()->with(['success' => true,'message'=>$message]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \CMS\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        $m = $message;
        $m->read = 1;
        $m->save();
        $message->inputs = json_decode($m->data);
        $message->form_name = Form::where('id',$m->form_id)->first()->name;
        return view('cms::panel.message.show',compact('message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CMS\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message->delete();
    }
}



