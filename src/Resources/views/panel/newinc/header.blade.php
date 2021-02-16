
@php($messages = \CMS\Models\Message::where('read',0)->get())
<nav class="navbar navbar-header navbar-expand navbar-light">
    <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
    <button class="btn navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav d-flex align-items-center navbar-light ml-auto">
            <li class="dropdown nav-icon">
                <a href="#" data-toggle="dropdown" class="nav-link  dropdown-toggle nav-link-lg nav-link-user">
                    <div class="d-lg-inline-block">
                        <i data-feather="mail"></i>
                        <div class="btn btn-primary" style="font-size:x-small;position: absolute;padding:2px;top: 0px;right: 5px;border-radius: 14px;color: white;width: 14px;">{!! count($messages) !!}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-large">
                    <h6 class='py-2 px-4'>{!! trans('cms::panel.notificaions') !!}</h6>
                    <ul class="list-group rounded-none">
                        <li class="list-group-item border-0 align-items-start">
                            @foreach($messages as $massage)
                                <div class="avatar bg-success mr-3">
                                    <span class="avatar-content"><i data-feather="message-circle"></i></span>
                                </div>
                                <div>
                                    <a href="{!! route('forms.messages.index',['form' => $massage->form->id]) !!}">
                                        <h6 class='text-bold'>{!! $massage->form->name !!} </h6>
                                        <p class='text-xs'>
                                            {!! trans('cms::panel.unread_form') !!}
                                        </p>
                                    </a>
                                </div>
                            @endforeach
                        </li>
                    </ul>
                </div>
            </li>
            {{--            <li class="dropdown nav-icon mr-2">--}}
            {{--                <a href="#" data-toggle="dropdown" class="nav-link  dropdown-toggle nav-link-lg nav-link-user">--}}
            {{--                    <div class="d-lg-inline-block">--}}
            {{--                        <i data-feather="mail"></i>--}}
            {{--                    </div>--}}
            {{--                </a>--}}
            {{--                <div class="dropdown-menu dropdown-menu-right">--}}
            {{--                    <a class="dropdown-item" href="#"><i data-feather="user"></i> Account</a>--}}
            {{--                    <a class="dropdown-item active" href="#"><i data-feather="mail"></i> Messages</a>--}}
            {{--                    <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a>--}}
            {{--                    <div class="dropdown-divider"></div>--}}
            {{--                    <a class="dropdown-item" href="#"><i data-feather="log-out"></i> Logout</a>--}}
            {{--                </div>--}}
            {{--            </li>--}}
            <li class="dropdown">
                <a href="" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <div class="avatar mr-1">
                        @if (app()->currentLocale() == "tr")
                            <img src="{!! asset('vendor/cms/images/turkey_flag.png') !!}" alt="" srcset="">
                        @else
                            <img src="{!! asset('vendor/cms/images/united-kingdom-flag.png') !!}" alt="" srcset="">
                        @endif
                    </div>
                    <div class="d-none d-md-block d-lg-inline-block">{!! Auth::user()->email !!}</div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item language" href=" {!! route('panel',['language' => 'tr']) !!}">
                        <div class="avatar mr-1 ">
                            <img src="{!! asset('vendor/cms/images/turkey_flag.png') !!}" alt="" srcset="">
                        </div>
                        Türkçe
                    </a>
                    <a class="dropdown-item language" href="{!! route('panel',['language' => 'en']) !!}">
                        <div class="avatar mr-1">
                            <img src="{!! asset('vendor/cms/images/united-kingdom-flag.png') !!}" alt="" srcset="">
                        </div>
                        English
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
