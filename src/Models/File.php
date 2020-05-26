<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends BaseModel
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'extension', 'path', 'size', 'status'
    ];

    public function page_detail()
    {
        return $this->belongsToMany(PageDetail::class,'file_page_detail','file_id','page_detail_id')->withPivot('key');
    }

    public function page()
    {
        return $this->belongsToMany(PageDetail::class,'file_page','file_id','page_id')->withPivot('key');
    }
}
