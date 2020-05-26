<?php


namespace CMS\Facades;


class ModuleFacade
{
    public static function all(){
        $m1 = collect(); $m2 = collect(); $m3 = collect(); $m4 = collect(); $m5 = collect();
        $m6 = collect(); $m7 = collect(); $m8 = collect();

        $m1->id = CONTENT; $m1->name = 'content';
        $m2->id = LANGUAGE; $m2->name = 'language';
        $m3->id = FORM; $m3->name = 'form';
        $m4->id = EBULLETIN; $m4->name = 'ebulletin';
//        $m5->id = USER; $m5->name = 'user';
        $m6->id = META; $m6->name = 'meta';
        $m7->id = CATEGORY; $m7->name = 'category';
        $m8->id = REDIRECT; $m8->name = 'redirect';

        $modules = collect();
        $modules->add($m1); $modules->add($m2); $modules->add($m3); $modules->add($m4);
//        $modules->add($m5);
        $modules->add($m6); $modules->add($m7); $modules->add($m8);
        return $modules;
    }
}
