<?php

namespace CMS\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use SoftDeletes;
    protected $fillable = ['lang_id','name','status','slug'];

    public function images()
    {
        return $this->hasMany(SliderItems::class,'slider_id');
    }
}
