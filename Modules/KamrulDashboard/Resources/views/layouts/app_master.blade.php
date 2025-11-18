<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
{{--    <title>@yield('title') - {{ getSetting('site_name', 'site_setting') }}</title>--}}
    <title>{{ page_title()->getTitle() }}</title>
    <!-- Favicon icon -->
{{--    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('vendor/kamruldashboard/images/favicon.png') }}">--}}
    <link rel="icon" type="image/png" sizes="16x16" href="{{ getImageUrlById(theme_option('favicon'), 'shortcodes') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('stylesheet')

    @stack('header')

    {!! Assets::renderHeader() !!}

</head>


<body>

<!--*******************
    Preloader start
********************-->
<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>
<!--*******************
    Preloader end
********************-->


<!--**********************************
    Main wrapper start
***********************************-->
<div id="main-wrapper">

    <!--**********************************
        Nav header start
    ***********************************-->
    @include('kamruldashboard::layouts.components.head')
    <!--**********************************
        Nav header end
    ***********************************-->

    <!--**********************************
        Header start
    ***********************************-->
    @include('kamruldashboard::layouts.components.header')
    <!--**********************************
        Header end ti-comment-alt
    ***********************************-->

    <!--**********************************
        Sidebar start
    ***********************************-->
    @include('kamruldashboard::layouts.components.sidebar')

    <!--**********************************
        Sidebar end
    ***********************************-->

    <!--**********************************
        Content body start
    ***********************************-->

    <div class="content-body" id="app">
        <div class="container-fluid page-content">

{{--            <div class="row page-titles mx-0">--}}
{{--                <div class="col-sm-6 p-md-0">--}}
{{--                    <div class="welcome-text">--}}
{{--                        <h4>@lang('Hi, welcome back!')</h4>--}}
{{--                        <span class="ml-1">@yield('title')</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">--}}
{{--                    <ol class="breadcrumb">--}}
{{--                        <li class="breadcrumb-item"><a href="javascript:void(0)">{{ __('kamruldashboard::all_lang.dashboard') }}</a></li>--}}
{{--                        <li class="breadcrumb-item active"><a href="javascript:void(0)">@yield('title')</a></li>--}}
{{--                    </ol>--}}
{{--                </div>--}}
{{--            </div>--}}

            @php
                $response_data = Session::get('response_data');
            @endphp
            @isset($response_data)
                @if($response_data['status'] == 1)
                    <div class="alert alert-primary solid alert-dismissible fade show">
                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                        </button>
                        <strong>{{ __('kamruldashboard::all_lang.success') }}</strong> {{ $response_data['message'] }}
                    </div>
                @elseif($response_data['status'] == 0)
                    <div class="alert alert-danger solid alert-dismissible fade show">
                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                        </button>
                        <strong>{{ __('kamruldashboard::all_lang.error') }}</strong> {{ $response_data['message'] }}
                    </div>
                @endif
            @endisset

            @yield('content')
        </div>
    </div>
    <!--**********************************
        Footer start
    ***********************************-->

    @include('kamruldashboard::elements.common')

    @include('kamruldashboard::layouts.components.footer')


    <!--**********************************
        Footer end
    ***********************************-->

</div>
<!--**********************************
    Scripts
***********************************-->
<script type="text/javascript">
    var LaracmcVariables = LaracmcVariables || {};

    @if (Auth::check())
        LaracmcVariables.languages = {
        {{--tables: {!! json_encode(trans('kamruldashboard::tables'), JSON_HEX_APOS) !!},--}}
        {{--notices_msg: {!! json_encode(trans('kamruldashboard::notices'), JSON_HEX_APOS) !!},--}}
        pagination: {!! json_encode(trans('pagination'), JSON_HEX_APOS) !!},
        system: {
            'character_remain': '{{ trans('kamruldashboard::forms.character_remain') }}'
        },
    };
    {{--LaracmcVariables.authorized = "{{ setting('membership_authorization_at') &&Carbon\Carbon::now()->diffInDays(Carbon\Carbon::createFromFormat('Y-m-d H:i:s', setting('membership_authorization_at'))) <= 7 ? 1 : 0 }}";--}}
    @else
        LaracmcVariables.languages = {
        notices_msg: {!! json_encode(trans('kamruldashboard::notices'), JSON_HEX_APOS) !!},
    };
    @endif
</script>

{!! Assets::renderFooter() !!}

    @yield('javascript')

@push('footer')
    @routes
@endpush
<div id="stack-footer">
    @stack('footer')
</div>

{!! apply_filters(BASE_FILTER_FOOTER_LAYOUT_TEMPLATE, null) !!}
</body>
</html>
