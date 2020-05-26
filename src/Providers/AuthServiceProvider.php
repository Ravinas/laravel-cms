<?php

namespace CMS\Providers;

use CMS\Models\Ebulletin;
use CMS\Models\Form;
use CMS\Models\Language;
use CMS\Models\Message;
use CMS\Models\Meta;
use CMS\Models\Page;
use CMS\Models\Redirect;
use CMS\Models\Role;
use CMS\Models\User;

use CMS\Policies\EbulletinPolicy;
use CMS\Policies\FormPolicy;
use CMS\Policies\LanguagePolicy;
use CMS\Policies\MessagePolicy;
use CMS\Policies\MetaPolicy;
use CMS\Policies\PagePolicy;
use CMS\Policies\RedirectPolicy;
use CMS\Policies\RolePolicy;
use CMS\Policies\UserPolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Page::class => PagePolicy::class,
        Language::class => LanguagePolicy::class,
        Form::class => FormPolicy::class,
        Ebulletin::class => EbulletinPolicy::class,
        Message::class => MessagePolicy::class,
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Meta::class => MetaPolicy::class,
        Redirect::class => RedirectPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
