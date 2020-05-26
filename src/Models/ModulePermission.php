<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModulePermission extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'role_id', 'module_id', 'permission',
    ];
}
