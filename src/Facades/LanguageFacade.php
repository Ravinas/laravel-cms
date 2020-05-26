<?php

namespace CMS\Facades;


use CMS\Models\Language;
use Illuminate\Support\Facades\App;

class LanguageFacade
{
    public static function all()
    {

        $lang = Language::where('status',1)->get();

        return $lang;
    }

    public static function default()
    {

        $lang = Language::where('default',1)->first();
        if ($lang == null)
        {
            $lang = Language::where('code','tr')->first();
            $lang->default = 1;
            $lang->active = 1;
            $lang->save();
            App::setLocale("tr");
        }
        return $lang->id;
    }

    public static function active()
    {
        $locale = Language::where('code',App::getLocale())->first();
        return $locale->id;
    }

    public static function isDefault($lang_id)
    {
        if ($lang_id == LanguageFacade::default())
        {
            return true;
        }
        return false;
    }
}
