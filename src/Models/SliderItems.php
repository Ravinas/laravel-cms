<?php

namespace CMS\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SliderItems extends Model
{
    use SoftDeletes;
    protected $fillable = ['slider_id','file_id','general_text','sub_text','sub_text2','status','order'];
}
