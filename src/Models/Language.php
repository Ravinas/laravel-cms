<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public $timestamps = false;
    protected $fillable = ['name','code','default','status'];

}
