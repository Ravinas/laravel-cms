<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryDetail extends Model
{
    use SoftDeletes;
    protected $fillable = ['category_id','name','slug','status'];

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }
}
