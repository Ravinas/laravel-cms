<?php


namespace CMS\Facades;


class ModuleFacade
{
    public static function all(){
        $m1 = collect(); $m2 = collect(); $m3 = collect(); $m4 = collect(); $m5 = collect();
        $m6 = collect();

        $m1->id = CONTENT; $m1->name = 'content';
        $m2->id = FORM; $m2->name = 'form';
        $m3->id = EBULLETIN; $m3->name = 'ebulletin';
        $m4->id = USER; $m4->name = 'user';
        $m5->id = META; $m5->name = 'meta';
        $m6->id = REDIRECT; $m6->name = 'redirect';

        $modules = collect();
        $modules->add($m1); $modules->add($m2); $modules->add($m3); $modules->add($m4);
        $modules->add($m5); $modules->add($m6);
        return $modules;
    }
}
