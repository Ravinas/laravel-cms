<?php

namespace CMS\Providers;

use CMS\Commands\Install;
use CMS\Commands\Seed;
use CMS\Models\Language;
use CMS\Models\PageDetail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

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
        // collectionlarda paginate yapabilmeyi sağlayan reyiz
        if (!Collection::hasMacro('paginate')) {

            Collection::macro('paginate',
                function ($perPage = 15, $page = null, $options = []) {
                    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                    return (new LengthAwarePaginator(
                        $this->forPage($page, $perPage), $this->count(), $perPage, $page, $options))
                        ->withPath('');
                });
        }

        app()->setLocale('tr');
        if ($this->app->runningInConsole()) {
            $this->commands([
                 Seed::class,
                 Install::class
            ]);
        }

        $packageDir = dirname(__DIR__);

        //default dilin kodu urlde gözüksün mü
        app()->showDefaultLanguageCode = true;
        //app()->showDefaultLanguageCode = env('PRIME_DEFAULT_LANGUAGE_CODE');

        try {
            app()->activeLanguages = Language::where('status',1)->get();
            app()->defaultLanguage = Language::where('default',1)->first();
            app()->currentLanguage = Language::where('code',App::getLocale())->first();
            app()->otherLanguages = Language::where('code', '!=',App::getLocale())->where('status',1)->first();
            app()->searchPage = PageDetail::where('status',1)
                ->where('lang_id',app()->currentLanguage->id)
                ->whereHas('page',function($q){
                    $q->where('status',1)->where('type',3);
                })
                ->first();
        } catch ( \Exception $exception){
            echo PHP_EOL." FAILED TO ACCESS DATABASE ".PHP_EOL.$exception.PHP_EOL;
        }


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


        $this->publishes([
            $packageDir.'/Assets' => public_path('vendor/cms'),
            $packageDir.'/Resources/views/website' => resource_path('views/vendor/prime')
        ]);

    }

}
