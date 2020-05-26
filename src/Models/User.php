<?php

namespace CMS\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var
     * array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->hasOne('CMS\Role');
    }

    public function hasModulePermission($module_id,$permission){
        if($this->role_id <= 2){
            return 1;
        } else {
            $has = ModulePermission::where('role_id',$this->role_id)->where('module_id',$module_id)->where('permission',$permission)->first();
            if($has){ return 1;}
            else { return 0;}
        }
    }

    public function hasPagePermission($page_id,$permission){
        if($this->role_id <= 2){
            return 1;
        } else {
            $has = PagePermission::where('role_id',$this->role_id)->where('page_id',$page_id)->where('permission',$permission)->first();
            if($has){ return 1;}
            else { return 0;}
        }
    }
}
