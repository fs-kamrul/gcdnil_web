<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <a class="btn btn-light " target="_blank" href="{{ url('/') }}">
                        <i class="icon icon-world-2"></i> @lang('Visit Website')
                    </a>
                </div>

                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                            <i class="mdi mdi-account"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ url('kamruldashboard/user/'. \Illuminate\Support\Facades\Auth::id()) }}" class="dropdown-item">
                                <i class="icon-user"></i>
                                <span class="ml-2">@lang('kamruldashboard::all_lang.profile')</span>
                            </a>
                            <a href="{{ url('kamruldashboard/user/change_password/'. \Illuminate\Support\Facades\Auth::id()) }}" class="dropdown-item">
                                <i class="icon icon-unlocked"></i>
                                <span class="ml-2">@lang('kamruldashboard::lang.change_password')</span>
                            </a>
{{--                            <a target="_blank" href="{{ url('public/chat') }}" class="dropdown-item">--}}
{{--                                <i class="icon-envelope-open"></i>--}}
{{--                                <span class="ml-2">Live Chat </span>--}}
{{--                            </a>--}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    <i class="icon-key"></i>

                                    <span class="ml-2">@lang('kamruldashboard::all_lang.logout')</span>
                                </a>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
