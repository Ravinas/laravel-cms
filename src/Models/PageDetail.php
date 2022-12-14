<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageDetail extends BaseModel
{
    use SoftDeletes;
    protected $fillable = ['page_id', 'lang_id', 'name', 'content', 'url'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function extras()
    {
        return $this->hasMany(DetailExtra::class);
    }

    public function language(){
        return $this->belongsTo(Language::class,'lang_id');
    }

    public function files()
    {
        return $this->belongsToMany(File::class,'file_page_detail','page_detail_id','file_id')->withPivot('key');
    }

    public function getImage($key)
    {
        $file = File::whereHas('page_detail',function ($query) use ($key){
            $query->where('key',$key);
        })->first();
        if($file){
            return asset("/storage/".$file->path);
        } else {
            return "";
        }

    }

    public function meta(){
        return $this->hasOne(Meta::class,'page_detail_id');
    }

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        self::deleting(function ($pagedetail){
            $pagedetail->extras()->each(function ($extras)
            {
                $extras->delete();
            });
        });
    }
}
