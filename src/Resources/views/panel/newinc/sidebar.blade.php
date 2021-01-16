<div class="sidebar-wrapper active">
    <div class="sidebar-header">
        <img src="{!! asset('vendor/cms/yeni/images/plogo.png') !!}" alt="" srcset="" >
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
                <li class='sidebar-title'>Content</li>
                <li class="sidebar-item">
                    <a href="{!! route('menu.index') !!}" class='sidebar-link'>
                        <i data-feather="menu" width="20"></i>
                        <span>{!! trans('cms::panel.menu') !!}</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{!! route('slider.index') !!}" class='sidebar-link'>
                        <i data-feather="sliders" width="20"></i>
                        <span>{!! trans('cms::panel.slider') !!}</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{!! route('pages.index') !!}" class='sidebar-link'>
                        <i data-feather="layout" width="20"></i>
                        <span>{!! trans('cms::panel.pages') !!}</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{!! route('categories.index') !!}" class='sidebar-link'>
                        <i data-feather="slack" width="20"></i>
                        <span>{!! trans('cms::panel.categories') !!}</span>
                    </a>
                </li>
                <li class='sidebar-title'>Interaction</li>
                <li class="sidebar-item">
                    <a href="{!! route('forms.index') !!}" class='sidebar-link'>
                        <i data-feather="file-text" width="20"></i>
                        <span>{!! trans('cms::panel.forms') !!}</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{!! route('ebulletins.index') !!}" class='sidebar-link'>
                        <i data-feather="mail" width="20"></i>
                        <span>{!! trans('cms::panel.ebulletins') !!}</span>
                    </a>
                </li>
                <li class='sidebar-title'>Users & Roles</li>
                <li class="sidebar-item">
                    <a href="{!! route('roles.index') !!}" class='sidebar-link'>
                        <i data-feather="user-check" width="20"></i>
                        <span>{!! trans('cms::panel.roles') !!}</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{!! route('users.index') !!}" class='sidebar-link'>
                        <i data-feather="users" width="20"></i>
                        <span>{!! trans('cms::panel.users') !!}</span>
                    </a>
                </li>


                <li class='sidebar-title'>Settings</li>
                <li class="sidebar-item">
                    <a href="{!! route('languages.index') !!}" class='sidebar-link'>
                        <i data-feather="globe" width="20"></i>
                        <span>{!! trans('cms::panel.languages') !!}</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{!! route('metas.index') !!}" class='sidebar-link'>
                        <i data-feather="key" width="20"></i>
                        <span>{!! trans('cms::panel.metas') !!}</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{!! route('redirects.index') !!}" class='sidebar-link'>
                        <i data-feather="home" width="20"></i>
                        <span>{!! trans('cms::panel.redirects') !!}</span>
                    </a>
                </li>
        </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>
