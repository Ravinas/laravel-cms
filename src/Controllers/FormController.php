<?php

namespace CMS\Controllers;

use CMS\Models\Form;
use CMS\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CMS\Traits\LogAgent;
use Auth;

class FormController extends Controller
{
    use LogAgent;
    private $rules;
    private $error_messages;
    public function __construct()
    {
        $this->authorizeResource(Form::class);
        $this->rules = [
            'name' => 'required|max:50',
            'email' => 'required|email',
            'slug' => 'required|max:50',
            'rules' => 'required|json',
            'error_messages' => 'required|json',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $forms = Form::where('name','!=',null)->get();
        return view('cms::panel.form.index',compact('forms'));


//        $messages = Message::where('form_id','!=',0)->get();
//        return view('cms::panel.message.index',compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms::panel.form.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = Validator::make($request->all(),$this->rules);
        if($valid->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($valid);
        } else {
            $form = new Form();
            $form->name = $request->post('name');
            $form->email = $request->post('email');
            $form->slug = $request->post('slug');
            $form->rules = $request->post('rules');
            $form->error_messages = $request->post('error_messages');
            $form->save();
            $this->createLog($form,Auth::user()->id,"C");
            return redirect()->route('forms.index')->with(['type' => 'success', 'message' => 'form_created']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \CMS\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CMS\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function edit(Form $form)
    {
        return view('cms::panel.form.edit',compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \CMS\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Form $form)
    {
        $valid = Validator::make($request->all(),$this->rules);
        if($valid->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($valid);
        } else {
            $form->name = $request->post('name');
            $form->email = $request->post('email');
            $form->slug = $request->post('slug');
            $form->rules = $request->post('rules');
            $form->save();
            $this->createLog($form,Auth::user()->id,"U");
            return redirect()->route('forms.edit',['form' => $form])->with(['type' => 'success', 'message' => trans('cms::panel.form_saved')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CMS\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        $form->delete();
        return redirect()->route('forms.index')
            ->with('message',trans('cms::panel.form_deleted',['form_name'=> $form->name]))
            ->with('type','danger');
            $this->createLog($form,Auth::user()->id,"D");
    }
}
