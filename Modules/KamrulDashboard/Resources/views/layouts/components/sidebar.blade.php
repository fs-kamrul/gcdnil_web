<div class="quixnav">
    <div class="quixnav-scroll">
        {!! Menu::render('admin-sidebar-menu', '\Modules\KamrulDashboard\Http\AdminSidebarCustom'); !!}
{{--        <ul class="metismenu" id="menu">--}}
{{--            <li>--}}
{{--                <a class="has-arrow" href="javascript:void()" aria-expanded="false">--}}
{{--                    <i class="icon icon-analytics"></i>--}}
{{--                    <span class="nav-text">User Management</span>--}}
{{--                </a>--}}
{{--                <ul aria-expanded="false">--}}
{{--                    <li><a href="http://lara_cms.anik/kamruldashboard/user">User</a></li>--}}
{{--                    <li><a href="http://lara_cms.anik/kamruldashboard/role"><i class="icon-file-signature"></i> Role</a></li>--}}
{{--                    <li><a href="http://lara_cms.anik/kamruldashboard/permission"><i class="icon-file-signature"></i> <span class="nav-text">Permission</span></a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a class="has-arrow" href="javascript:void()" aria-expanded="false">--}}
{{--                    <i class="icon icon-users-mm-2"></i>--}}
{{--                    <span class="nav-text">Settings</span>--}}
{{--                </a>--}}
{{--                <ul aria-expanded="false">--}}
{{--                    <li><a href="{{ url('settings.edit', 1) }}">Settings</a></li>--}}
{{--                    <li><a href="{{ url('pages') }}">Pages</a></li>--}}
{{--                    <li><a href="{{ url('users/admin') }}">Admin Account</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--        </ul>--}}

{{--        <ul class="metismenu" id="menu">--}}
{{--            <li class="nav-label first">Main Menu</li>--}}
{{--            <li>--}}
{{--                <a class="" href="{{ url('dashboard') }}" aria-expanded="false">--}}
{{--                    <i class="icon icon-single-04"></i>--}}
{{--                    <span class="nav-text">Dashboard</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-label">Admin Tasks</li>--}}
{{--            <li>--}}
{{--                <a class="" href="{{ url('plugins') }}" aria-expanded="false">--}}
{{--                    <i class="icon-file-signature"></i>--}}
{{--                    <span class="nav-text">{{ __('kamruldashboard::all_lang.plugins') }}</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a class="" href="{{ url('packages') }}" aria-expanded="false">--}}
{{--                    <i class="icon-file-signature"></i>--}}
{{--                    <span class="nav-text">Packages</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a class="" href="{{ url('videos') }}" aria-expanded="false">--}}
{{--                    <i class="icon icon-app-store"></i>--}}
{{--                    <span class="nav-text">Videos</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a class="" href="{{ url('accounts') }}" aria-expanded="false">--}}
{{--                    <i class="icon-file-signature"></i>--}}
{{--                    <span class="nav-text">Purchase Request</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a class="" href="{{ url('withdraws_accounts') }}" aria-expanded="false">--}}
{{--                    <i class="icon icon-chart-bar-33"></i>--}}
{{--                    <span class="nav-text">Withdraws Request</span>--}}
{{--                </a>--}}
{{--            </li>--}}

{{--            <li>--}}
{{--                <a class="" href="{{ url('users') }}" aria-expanded="false">--}}
{{--                    <i class="icon icon-users-mm"></i>--}}
{{--                    <span class="nav-text">Users Infotmation</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-label">Report / Print</li>--}}
{{--            <li>--}}
{{--                <a class="has-arrow" href="javascript:void()" aria-expanded="false">--}}
{{--                    <i class="icon icon-analytics"></i>--}}
{{--                    <span class="nav-text">Report / Print</span></a>--}}
{{--                <ul aria-expanded="false">--}}
{{--                    <li><a href="{{ url('accounts_report') }}">Purchase Report</a></li>--}}
{{--                    <li><a href="{{ url('withdraws_report') }}">Withdraws Report</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li class="nav-label">Settings</li>--}}
{{--            <li>--}}
{{--                <a class="has-arrow" href="javascript:void()" aria-expanded="false"><i--}}
{{--                        class="icon icon-settings"></i><span class="nav-text">Settings</span>--}}
{{--                </a>--}}
{{--                <ul aria-expanded="false">--}}
{{--                    <li><a href="{{ url('settings.edit', 1) }}">Settings</a></li>--}}
{{--                    <li><a href="{{ url('pages') }}">Pages</a></li>--}}
{{--                    <li><a href="{{ url('users/admin') }}">Admin Account</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a class="" href="{{ url('profile') }}" aria-expanded="false">--}}
{{--                    <i class="icon-file-signature"></i>--}}
{{--                    <span class="nav-text">Profile</span>--}}
{{--                </a>--}}
{{--            </li>--}}

{{--            <li class="nav-label">Home Page</li>--}}
{{--            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i--}}
{{--                        class="icon icon-house-search-engine"></i><span class="nav-text">Home Page</span></a>--}}
{{--                <ul aria-expanded="false">--}}
{{--                    <li><a href="{{ url('homes') }}">Section One</a></li>--}}
{{--                    <li><a href="#">Section Two</a></li>--}}
{{--                    <li><a href="#">Tutorial page</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a class="" href="{{ url('tasks') }}" aria-expanded="false">--}}
{{--                    <i class="icon icon-world-2"></i>--}}
{{--                    <span class="nav-text">Tasks</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a class="" href="{{ url('withdraws') }}" aria-expanded="false">--}}
{{--                    <i class="icon icon-wallet-90"></i>--}}
{{--                    <span class="nav-text">Withdraws</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        </ul>--}}
    </div>


</div>
