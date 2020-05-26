<?php

namespace CMS\Providers;

use CMS\Facades\LanguageFacade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class CMS extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Config::set('auth.providers.users.model', \CMS\Models\User::class);
        //config()->set('auth.providers.users.model', \CMS\Models\User::class);
        //config(['auth.providers.users.model' => \CMS\Models\User::class]);

        $this->app->register(AuthServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $packageDir = dirname(__DIR__);
        app()->showDefaultLanguageCode = false;
        define('CONTENT',1);
        define('LANGUAGE',2);
        define('FORM',3);
        define('EBULLETIN',4);
        define('USER',5);
        define('META',6);
        define('CATEGORY', 7);
        define('REDIRECT',8);
        Schema::defaultStringLength(191);

        Route::middleware('web')
            ->namespace('CMS\Controllers')
            ->group($packageDir.'/Routes/web.php');


        $this->loadTranslationsFrom($packageDir.'/Resources/lang', 'cms');
        $this->loadMigrationsFrom($packageDir.'/Migrations');
        $this->loadViewsFrom($packageDir.'/Resources/views', 'cms');
        $this->loadBladeDirectives();

        //projenin resourceunda app.blade oluşturulacak

        $this->publishes([
            $packageDir.'/Assets' => public_path('vendor/cms'),
            $packageDir.'/Seeds' => base_path('/database/seeds'),
        ]);

    }

    public function loadBladeDirectives(){

        //file
        Blade::directive('filePage', function ($expression) {
            return '<button type="button" class="btn btn-primary file-select" data-toggle="modal" data-target="#filemanager" data-key="'.$expression.'">
                    '.trans("cms::panel.select_file").'
                </button>';
        });
        Blade::directive('filePageDetail', function ($arguments) {
            $arguments = explode(',',$arguments);
            return '<button type="button" class="btn btn-primary file-select-detail" data-toggle="modal" data-target="#filemanager" data-key="'.$arguments[0].'" data-pageDetail="'.$arguments[1].'">
                    '.trans("cms::panel.select_file").'
                </button>';
        });

        //text
        Blade::directive('textExtra', function ($arguments) {
            return '<input type="text" class="form-control" name="extras['.$arguments.']" value="{!! $page->'.$arguments.' !!}"/>';
        });
        Blade::directive('textDetailExtra', function ($arguments) {
            $arguments = explode(',',$arguments);
            return '<input type="text" class="form-control" name="detail_extras['.$arguments[1].']['.$arguments[0].']" value="{!! $pd->'.$arguments[0].' !!}"/>';
        });

        //date

        //select

        //checkbox

        //radio
    }

}
