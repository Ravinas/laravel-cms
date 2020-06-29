<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ['user_id','loggable_id','loggable_type','crud'];

    public function loggable()
    {
        return $this->morphTo();
    }

}
