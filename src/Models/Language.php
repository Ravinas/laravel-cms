<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public $timestamps = false;
    protected $fillable = ['name','code','default','status'];

    public function menu(){
        
        return $this->hasMany(Menu::class,'lang_id');

    }

    public function slider(){
        
        return $this->hasMany(Slider::class,'lang_id');

    }

}
