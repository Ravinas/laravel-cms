<div class="sidebar-wrapper active">
    <div class="sidebar-header">
        <img src="{!! asset('vendor/cms/yeni/images/plogo.png') !!}" alt="" srcset="" >
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
                @if(Auth::user()->hasModulePermission(CONTENT,'R'))
                <li class='sidebar-title'>{{ trans('cms::panel.content') }}</li>
                <li class="sidebar-item {{ request()->routeIs('menu*') ? 'active' : '' }}">
                    <a href="{!! route('menu.index') !!}" class='sidebar-link'>
                        <i data-feather="menu" width="20"></i>
                        <span>{!! trans('cms::panel.menu') !!}</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('slider*') ? 'active' : '' }}">
                    <a href="{!! route('slider.index') !!}" class='sidebar-link'>
                        <i data-feather="sliders" width="20"></i>
                        <span>{!! trans('cms::panel.slider') !!}</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('pages*') ? 'active' : '' }}">
                    <a href="{!! route('pages.index') !!}" class='sidebar-link'>
                        <i data-feather="layout" width="20"></i>
                        <span>{!! trans('cms::panel.pages') !!}</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('categories*') ? 'active' : '' }}">
                    <a href="{!! route('categories.index') !!}" class='sidebar-link'>
                        <i data-feather="slack" width="20"></i>
                        <span>{!! trans('cms::panel.categories') !!}</span>
                    </a>
                </li>
                @endif
                <li class='sidebar-title'>{{ trans('cms::panel.interaction') }}</li>
                @if(Auth::user()->hasModulePermission(FORM,'R'))
                <li class="sidebar-item {{ request()->routeIs('forms*') ? 'active' : '' }}">
                    <a href="{!! route('forms.index') !!}" class='sidebar-link'>
                        <i data-feather="file-text" width="20"></i>
                        <span>{!! trans('cms::panel.forms') !!}</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasModulePermission(EBULLETIN,'R'))
                <li class="sidebar-item {{ request()->routeIs('ebulletins*') ? 'active' : '' }}">
                    <a href="{!! route('ebulletins.index') !!}" class='sidebar-link'>
                        <i data-feather="mail" width="20"></i>
                        <span>{!! trans('cms::panel.ebulletins') !!}</span>
                    </a>
                </li>
                @endif
                <li class='sidebar-title'>{{ trans('cms::panel.roles') }} & {{ trans('panel.roles') }}</li>
                @if(Auth::user()->hasModulePermission(USER,'R'))
                <li class="sidebar-item {{ request()->routeIs('roles*') ? 'active' : '' }}">
                    <a href="{!! route('roles.index') !!}" class='sidebar-link'>
                        <i data-feather="user-check" width="20"></i>
                        <span>{!! trans('cms::panel.roles') !!}</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasModulePermission(USER,'R'))
                <li class="sidebar-item {{ request()->routeIs('users*') ? 'active' : '' }}">
                    <a href="{!! route('users.index') !!}" class='sidebar-link'>
                        <i data-feather="users" width="20"></i>
                        <span>{!! trans('cms::panel.users.title') !!}</span>
                    </a>
                </li>
                @endif

                <li class='sidebar-title'>{{ trans('cms::panel.settings') }}</li>
                @if(Auth::user()->hasModulePermission(LANGUAGE,'R'))
                <li class="sidebar-item {{ request()->routeIs('languages*') ? 'active' : '' }}">
                    <a href="{!! route('languages.index') !!}" class='sidebar-link'>
                        <i data-feather="globe" width="20"></i>
                        <span>{!! trans('cms::panel.languages') !!}</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasModulePermission(META,'R'))
                <li class="sidebar-item {{ request()->routeIs('metas*') ? 'active' : '' }}">
                    <a href="{!! route('metas.index') !!}" class='sidebar-link'>
                        <i data-feather="key" width="20"></i>
                        <span>{!! trans('cms::panel.metas.title') !!}</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasModulePermission(REDIRECT,'R'))
                <li class="sidebar-item {{ request()->routeIs('redirects*') ? 'active' : '' }}">
                    <a href="{!! route('redirects.index') !!}" class='sidebar-link'>
                        <i data-feather="home" width="20"></i>
                        <span>{!! trans('cms::panel.redirects.title') !!}</span>
                    </a>
                </li>
                @endif
        </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>
