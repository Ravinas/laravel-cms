<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'form_id', 'ip', 'data','read'
    ];

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
}
