<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title') - {{ getSetting('site_name', 'site_setting') }}</title>
    <!-- Favicon icon -->
{{--    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('vendor/kamruldashboard/images/favicon.png') }}">--}}
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('uploads/settings/'.getSetting('site_favicon', 'site_setting')) }}">

    @yield('stylesheet')


    <link href="{{ url('vendor/kamruldashboard/css/style.css') }}" rel="stylesheet">


</head>


<body class="h-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
        Footer start
    ***********************************-->
    {{--    @include('kamruldashboard::layouts.components.footer')--}}
    <!--**********************************
        Footer end
    ***********************************-->
    <script src="{{ url('vendor/kamruldashboard/vendor/global/global.min.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/js/quixnav-init.js') }}"></script>
    <script src="{{ url('vendor/kamruldashboard/js/custom.min.js') }}"></script>


    @yield('javascript')

</body>
</html>
