<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
    ];

    public function users(){
        return $this->belongsTo('CMS\User');
    }

    public function permissions(){
        return $this->hasMany('CMS\Permission');
    }

    public function hasModulePermission($module_id,$permission){
        $check = ModulePermission::where('role_id',$this->id)
            ->where('module_id',$module_id)
            ->where('permission',$permission)
            ->first();
        return ($check ? true : false);
    }

    public function hasPagePermission($page_id,$permission){
        $check = PagePermission::where('role_id',$this->id)
            ->where('page_id',$page_id)
            ->where('permission',$permission)
            ->first();
        return ($check ? true : false);
    }
}
