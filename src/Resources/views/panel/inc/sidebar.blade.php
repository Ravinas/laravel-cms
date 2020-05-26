<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li>
                    <a class="waves-effect waves-dark" href="/panel" aria-expanded="false">
                        <i class="mdi mdi-gauge"></i><span class="hide-menu">{!! trans('cms::panel.dashboard') !!}</span>
                    </a>
                </li>
                @if(Auth::user()->hasModulePermission(CONTENT,'R'))
                <li>
                    <a class="waves-effect waves-dark" href="{!! route('pages.index') !!}">
                        <i class="mdi mdi-book-open-page-variant"></i><span class="hide-menu">{!! trans('cms::panel.pages') !!}</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasModulePermission(LANGUAGE,'R'))
                <li>
                    <a class="waves-effect waves-dark" href="{!! route('languages.index') !!}">
                        <i class="mdi mdi-text-to-speech"></i><span class="hide-menu">{!! trans('cms::panel.languages') !!}</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasModulePermission(FORM,'R'))
                <li>
                    <a class="waves-effect waves-dark" href="{!! route('forms.index') !!}">
                        <i class="mdi mdi-book-open"></i><span class="hide-menu">{!! trans('cms::panel.forms') !!}</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasModulePermission(EBULLETIN,'R'))
                <li>
                    <a class="waves-effect waves-dark" href="{!! route('ebulletins.index') !!}">
                        <i class="mdi mdi-message-text"></i><span class="hide-menu">{!! trans('cms::panel.ebulletins') !!}</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasModulePermission(USER,'R'))
                <li>
                    <a class="waves-effect waves-dark" href="{!! route('users.index') !!}">
                        <i class="mdi mdi-account-multiple"></i><span class="hide-menu">{!! trans('cms::panel.users') !!}</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasModulePermission(USER,'R'))
                <li>
                    <a class="waves-effect waves-dark" href="{!! route('roles.index') !!}">
                        <i class="mdi mdi-security"></i><span class="hide-menu">{!! trans('cms::panel.roles') !!}</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasModulePermission(META,'R'))
                    <li>
                        <a class="waves-effect waves-dark" href="{!! route('metas.index') !!}">
                            <i class="mdi mdi-earth"></i><span class="hide-menu">{!! trans('cms::panel.metas') !!}</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->hasModulePermission(CATEGORY,'R'))
                    <li>
                        <a class="waves-effect waves-dark" href="{!! route('categories.index') !!}">
                            <i class="mdi mdi-sort-variant"></i><span class="hide-menu">{!! trans('cms::panel.categories') !!}</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->hasModulePermission(REDIRECT,'R'))
                    <li>
                        <a class="waves-effect waves-dark" href="{!! route('redirects.index') !!}">
                            <i class="mdi mdi-tumblr-reblog"></i><span class="hide-menu">{!! trans('cms::panel.redirects') !!}</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <!-- Bottom points-->
    <div class="sidebar-footer">
        <!-- item--><a href="" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a>
        <!-- item--><a href="" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
        <!-- item--><a href="" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a> </div>
    <!-- End Bottom points-->
</aside>
