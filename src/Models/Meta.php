<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meta extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'page_detail_id', 'description', 'keywords' , 'robots'
    ];

    public function pageDetail(){
        return $this->belongsTo('CMS\PageDetail','page_detail_id','id');
    }

}
