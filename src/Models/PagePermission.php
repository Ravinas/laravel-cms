<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagePermission extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'role_id', 'page_id', 'permission',
    ];
}
