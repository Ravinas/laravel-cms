<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['lang_id','name','status','slug'];

    public function items()
    {
        return $this->hasMany(MenuItem::class,'menu_id')->orderBy('order');
    }
}
