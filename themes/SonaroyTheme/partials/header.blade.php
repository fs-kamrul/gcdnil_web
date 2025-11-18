<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>


    {!! Theme::header() !!}

    @php
        $slider_logo = theme_option('logo_color');
    @endphp
    <script>
        window.siteUrl = "{{ url('') }}";
        window.siteEditorLocale = "{{ apply_filters('cms_site_editor_locale', App::getLocale()) }}";
    </script>
    @php
        $headerStyle = theme_option('header_style') ?: '';
        $page = Theme::get('page');
        if ($page) {
            $headerStyle = $page->getMetaData('header_style', true) ?: $headerStyle;
        }
        $headerStyle = ($headerStyle && in_array($headerStyle, array_keys(get_layout_header_styles()))) ? $headerStyle : '';
//            dd($headerStyle);
    @endphp
</head>
<body>
<!-- Spinner Start -->
{{--    @if(theme_option('preloader_enabled') == 'yes')--}}
{{--    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">--}}
{{--        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">--}}
{{--            <span class="sr-only">@lang('Loading')...</span>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    @endif--}}
<!-- Spinner End -->
<!-- --------------- Header Start --------------- -->
@php
    $logo_image = theme_option('logo');

    $baseUrl = url('/');

// Get the current full URL
//    $currentUrl = \Illuminate\Support\Facades\Request::fullUrl();

//    dd(strpos($currentUrl, $baseUrl));
// Check if the current URL starts with the base URL
//    if ($currentUrl === $baseUrl) {
//        dd("Current URL is within the base URL.");
//        print_r("<section id=\"hero\">");
//    }
//    else {
//        dd("Current URL is outside the base URL.");
//    }

@endphp

{{--                <h2 class="mb-2 text-white">{{ theme_option('site_title') }}</h2>--}}
{{--    <img class="logo" src="{{ getImageUrl($logo_image, 'shortcodes') }}"--}}
{{--         alt="{{ theme_option('site_title') }}">--}}
<!-- --------------------- Navbar Start --------------------- -->

{{--<div class="modal fade" id="myModal" role="dialog" tabindex="-1" style="display: none;margin: 5px;text-align: center;">--}}
{{--    <div class="modal-dialog text-center">--}}
{{--        <!-- Modal content-->--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-body">--}}
{{--                <button class="btn-for-accessibility" data-dismiss="modal" onclick="accessibilitymodelClose()">--}}
{{--                    Skip to main content--}}
{{--                </button>--}}
{{--                <button class="btn-for-accessibility" id="accessibilitypop" onclick="accessibility()">--}}
{{--                    Go to accessibility menu--}}
{{--                </button>--}}
{{--                <button class="btn-for-accessibility close" type="button" data-dismiss="modal"--}}
{{--                        onclick="accessibilitymodelClose()">&times;--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}
{{--</div>--}}

<div class="container">

    {{--    <div id="start-np" autofocus="autofocus" style="opacity:0;font-size:1px;position: absolute;" aria-selected="true"--}}
    {{--         tabindex="0">Wellcome to National Portal--}}
    {{--    </div>--}}
    <div class="sixteen columns"
         style="background-color: #683091; box-shadow: 0 1px 5px #999999;width: 960px;border-bottom: 4px solid #8bc643;">
        <div class="slide-panel-btns">
            <div class="slide-panel-button" style="display: table;margin-top: 5px;">
                <!-- <i class="flaticon-menu10"></i> target="_blank"-->
                <a style="color: white;font-size:.9em;"
                   href="{{ url('/') }}" >
                    {{ theme_option('site_title') }}</a>
            </div>

        </div>
        <div id="div-lang">
            <div id="newNavigation"></div>
            <div id="div-lang-sel">

                <div style="float: left;margin-left: 5px">

{{--                    <div id="lang_form" action="" method="post">--}}
{{--                        <button type="submit" style="padding: 2px;margin-top: 5px">বাংলা</button>--}}
{{--                    </div>--}}
                    @if (is_module_active('Language'))
                        {!! Theme::partial('language-switcher') !!}
                    @endif
                </div>
            </div>

        </div>
    </div>
    <!-- --------------- Header End --------------- -->
    {{--    <img src="{{ getImageUrlById($logo_image, 'shortcodes') }}"--}}
    {{--         alt="{{ theme_option('site_title') }}">--}}
    {{--    {!! Menus::renderMenuLocation('main-menu', [--}}
    {{--        'view'    => 'menu',--}}
    {{--        'status'    => 'nav-item nav-link',--}}
    {{--        'options' => ['class' => 'navbar-nav nav_middle'],--}}
    {{--    ]) !!}--}}
    {{--    {!! Menus::renderMenuLocation('header-menu', [--}}
    {{--        'view'    => 'menu_right',--}}
    {{--        'status'    => 'nav-item nav-link',--}}
    {{--        'options' => ['class' => 'navbar-nav nav_right'],--}}
    {{--    ]) !!}--}}
    <!-- --------------- Header End --------------- -->

    <style>
        .banner_container{
            background-image: url('{{ getImageUrlById(theme_option('logo_color'), 'shortcodes') }}');
        }
    </style>
    <div class="sixteen columns">
        <div class="banner_container"></div>
        <div class="header-site-info" id="header-site-info">
            <div>
                <div id="logo">
                    <a title="Home" href="{{ url('/') }}">
                        <img alt="Home" src="{{ getImageUrlById($logo_image, 'shortcodes') }}">
                    </a>
                </div>
                <div class="clearfix" id="site-name-wrapper">
				<span id="site-name">
					<a title="Home" href="{{ url('/') }}">
						{{ theme_option('site_title') }}
                    </a>
				</span>
                    <span id="slogan"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="sixteen columns" id="jmenu">
        <div class="sixteen columns menu">

{{--            <li class="col0 "><a title="Home" href="{{ url('/') }}"--}}
{{--                                 style="background-image: url('themes/{{ Theme::getThemeName() }}/images/home_dark.png');margin-top:5px;"></a>--}}
{{--            </li>--}}
            <a href="javascript:;" class="show-menu menu-head" ></a>
{{--            <a href="javascript:void(0);" class="show-menue" onclick="showMenuFunction()">--}}
{{--               ffffffffff <i class="fa fa-bars"></i>--}}
{{--            </a>--}}
            <div role="navigation" id="dawgdrops">
                {!! Menus::renderMenuLocation('main-menu', [
                    'view'    => 'menu_custom',
                    'status'    => 'nav-item nav-link',
                    'options' => ['class' => 'meganizr mzr-slide mzr-responsive'],
                ]) !!}
            </div>
        </div>
    </div>

