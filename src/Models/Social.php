<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{

    protected $fillable = ["name","class","url","order","icon"];
}
