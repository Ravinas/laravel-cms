<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use SoftDeletes;
    protected $fillable = ['menu_id','parent_id','type','order','text','url'];

    public function children()
    {
        return $this->hasMany(MenuItem::class,'parent_id')->orderby('order');
    }
}
