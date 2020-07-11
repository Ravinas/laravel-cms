<?php

namespace CMS\Controllers;

use CMS\Facades\LanguageFacade;
use CMS\Facades\ModuleFacade;
use CMS\Models\ModulePermission;
use CMS\Models\Page;
use CMS\Models\PagePermission;
use CMS\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CMS\Traits\LogAgent;
use Auth;

class RoleController extends Controller
{
    use LogAgent;

    public function __construct()
    {
        $this->authorizeResource(Role::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::where('id','>',2)->get();
        return view('cms::panel.role.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = ModuleFacade::all();
        $pages = Page::join('page_details','pages.id','=','page_details.page_id')
            ->where('pages.page_id',0)
            ->where('page_details.lang_id',LanguageFacade::active())
            ->select('pages.*','page_details.name')
            ->get();
        return view('cms::panel.role.create',compact('modules','pages'));
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
            'name' => 'required|unique:roles|max:30',
        ];
        $valid = Validator::make($request->all(),$rules);
        if($valid->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($valid);
        } else {
            $role = new Role();
            $role->name = $request->post('name');
            $role->status = 1;
            if($role->save()) {
                $modules = ModuleFacade::all()->pluck('id');
                $pages = Page::where('page_id',0)->pluck('id');
                $module_permissions= [];
                $page_permissions= [];
                foreach($modules as $m){
                    $module_permissions[] = [
                        'role_id' => $role->id,
                        'module_id' => $m,
                        'permission' => 'C',
                    ];
                    $module_permissions[] = [
                        'role_id' => $role->id,
                        'module_id' => $m,
                        'permission' => 'R',
                    ];
                    $module_permissions[] = [
                        'role_id' => $role->id,
                        'module_id' => $m,
                        'permission' => 'U',
                    ];
                    $module_permissions[] = [
                        'role_id' => $role->id,
                        'module_id' => $m,
                        'permission' => 'D',
                    ];
                }

                foreach($pages as $p){
                    $page_permissions[] = [
                        'role_id' => $role->id,
                        'page_id' => $p,
                        'permission' => 'C',
                    ];
                    $page_permissions[] = [
                        'role_id' => $role->id,
                        'page_id' => $p,
                        'permission' => 'R',
                    ];
                    $page_permissions[] = [
                        'role_id' => $role->id,
                        'page_id' => $p,
                        'permission' => 'U',
                    ];
                    $page_permissions[] = [
                        'role_id' => $role->id,
                        'page_id' => $p,
                        'permission' => 'D',
                    ];
                }
                // Tüm modüller ve sayfalar için yetki oluştur
                ModulePermission::insert($module_permissions);
                PagePermission::insert($page_permissions);

                // Tüm yetkileri soft delete olarak sil
                ModulePermission::where('role_id',$role->id)->delete();
                PagePermission::where('role_id',$role->id)->delete();

                // Seçili modül yetkilerini aktifleştir
                if($request->post('module'))
                {
                    foreach($request->post('module') as $module_id => $perms)
                    {
                        ModulePermission::withTrashed()
                            ->where('role_id',$role->id)
                            ->where('module_id',$module_id)
                            ->whereIn('permission',$perms)
                            ->restore();
                    }
                }


                // Seçili tüm page yetkilerini aktifleştir
                if($request->post('page'))
                {
                    foreach($request->post('page') as $page_id => $perms)
                    {
                        PagePermission::withTrashed()
                            ->where('role_id',$role->id)
                            ->where('page_id',$page_id)
                            ->whereIn('permission',$perms)
                            ->restore();
                    }
                }

                return redirect()->route('roles.index')
                    ->with('message',trans('cms::role.created'))
                    ->with('type','success');;

            } else {

            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \CMS\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CMS\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if($role->id <= 2){
            return abort(403);
        }
        $modules = ModuleFacade::all();
        $pages = Page::join('page_details','pages.id','=','page_details.page_id')
            ->where('pages.page_id',0)
            ->where('page_details.lang_id',LanguageFacade::active())
            ->select('pages.*','page_details.name')
            ->get();
        return view('cms::panel.role.edit',compact('role','modules','pages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \CMS\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        if($role->id <= 2){
            return abort(403);
        }
        $rules = [
            'name' => 'required|max:30',
        ];
        $valid = Validator::make($request->all(),$rules);
        if($valid->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($valid);
        } else {
            $role->name = $request->post('name');
            $role->status = 1;
            if($role->save()) {
                $this->createLog($role,Auth::user()->id,"C");

                // Tüm yetkileri soft delete olarak sil
                ModulePermission::where('role_id',$role->id)->delete();
                PagePermission::where('role_id',$role->id)->delete();

                // Seçili modül yetkilerini aktifleştir
                if($request->post('module'))
                {
                    foreach($request->post('module') as $module_id => $perms)
                    {
                        ModulePermission::withTrashed()
                            ->where('role_id',$role->id)
                            ->where('module_id',$module_id)
                            ->whereIn('permission',$perms)
                            ->restore();
                    }
                }


                // Seçili tüm page yetkilerini aktifleştir
                if($request->post('page'))
                {
                    foreach($request->post('page') as $page_id => $perms)
                    {
                        PagePermission::withTrashed()
                            ->where('role_id',$role->id)
                            ->where('page_id',$page_id)
                            ->whereIn('permission',$perms)
                            ->restore();
                    }
                }

                return redirect()->route('roles.index')
                    ->with('message',trans('cms::role.edited'))
                    ->with('type','success');;

            } else {
                return abort(500);
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CMS\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if($role->id == 1){
            return abort(403);
        }
        $role->delete();
        $this->createLog($role,Auth::user()->id,"D");
        // silinen rolün yetkileri neydi diye tutulmalı mı silinmeli mi
        ModulePermission::where('role_id',$role->id)->forceDelete();
        PagePermission::where('role_id',$role->id)->forceDelete();
        return redirect()->route('roles.index')
            ->with('message',trans('cms::roles.deleted'))
            ->with('type','danger');
    }
}
