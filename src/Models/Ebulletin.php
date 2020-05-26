<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ebulletin extends Model
{
    use SoftDeletes;

    protected $fillable = ['lang_id','email','status'];
}
