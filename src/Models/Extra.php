<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extra extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['page_id','key','value','label'];

    public function page()
    {
        return $this->belongsTo('CMS\Page');
    }
}
