<?php

namespace CMS\Controllers;

use CMS\Models\Role;
use CMS\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use CMS\Traits\LogAgent;
use Auth;

class UserController extends Controller
{
    use LogAgent;
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::join('roles', 'roles.id','=','users.role_id')
            ->select('users.*','roles.name as roleName')
            ->where('users.role_id','>',1)
            ->paginate(15);
        return view('cms::panel.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('id' , '>', 1)->get();
        $this->createLog($roles,Auth::user()->id,"C");
        return view('cms::panel.user.create',compact('roles'));
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
            'role' => 'required|integer|min:2',
            'name' => 'required|max:100',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
        $valid = Validator::make($request->all(),$rules);
        if($valid->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($valid);
        } else {
            $user = new User();
            $user->name = $request->post('name');
            $user->email = $request->post('email');
            $user->role_id = $request->post('role');
            $user->password = Hash::make($request->post('password'));
            $user->save();
            $this->createLog($user,Auth::user()->id,"U");
            return redirect()->route('users.index')->with(['type' => 'success', 'message' => 'form_created']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \CMS\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CMS\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if($user->role_id == 1){
            return abort(403);
        }
        $roles = Role::where('id' , '>', 1)->get();
        return view('cms::panel.user.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \CMS\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if($user->role_id == 1){
            return abort(403);
        }
        if($request->post('password') === null && $request->post('password_confirmation') === null){
            $rules = [
                'role' => 'required|integer|min:2',
                'name' => 'required|max:100',
                'email' => 'required|email',
            ];
            $valid = Validator::make($request->all(),$rules);
            if($valid->fails()) {
                return redirect()->back()
                    ->withInput($request->all())
                    ->withErrors($valid);
            } else {
                $user->name = $request->post('name');
                $user->email = $request->post('email');
                $user->role_id = $request->post('role');
            }
            $user->save();
            return redirect()->route('users.index')->with(['type' => 'success', 'message' => 'user_edited']);

        } else {
            $rules = [
                'role' => 'required|integer',
                'name' => 'required|max:100',
                'email' => 'required|email',
                'password' => 'required|confirmed|min:6',
            ];
            $valid = Validator::make($request->all(),$rules);
            if($valid->fails()) {
                return redirect()->back()
                    ->withInput($request->all())
                    ->withErrors($valid);
            } else {
                $user->name = $request->post('name');
                $user->email = $request->post('email');
                $user->role_id = $request->post('role');
                $user->password = Hash::make($request->post('password'));
            }
            $user->save();
            $this->createLog($user,Auth::user()->id,"U");
            return redirect()->route('users.index')->with(['type' => 'success', 'message' => 'user_edited']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CMS\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        $this->createLog($user,Auth::user()->id,"D");
        return redirect()->route('users.index')
            ->with('message',trans('cms::user.deleted'))
            ->with('type','danger');
    }
}
