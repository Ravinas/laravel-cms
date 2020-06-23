<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'email', 'slug', 'rules', 'error_messages'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
