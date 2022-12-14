<?php

namespace CMS\Models;
use CMS\Facades\LanguageFacade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends BaseModel
{
    use SoftDeletes;
    protected $fillable = [
        'page_id', 'view', 'order', 'status' , 'type'
    ];


    public function details(){
        return $this->hasMany(PageDetail::class);
    }

    public function detail()
    {
        return $this->hasOne(PageDetail::class)->where('lang_id',LanguageFacade::active());
    }

    public function extras(){
        return $this->hasMany(Extra::class);
    }

    public function parent()
    {
        return $this->hasOne(Page::class,'page_id');
    }

    public function files()
    {
        return $this->belongsToMany(File::class,'file_page','page_id','file_id')->withPivot('key');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function logs()
    {
        return $this->morphMany(Log::class,'loggable');
    }

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        self::deleting(function ($page){
            $page->details()->each(function ($detail)
            {
                $detail->delete();
            });
            $page->extras()->each(function ($extra)
            {
                $extra->delete();
            });
        });
    }

}
