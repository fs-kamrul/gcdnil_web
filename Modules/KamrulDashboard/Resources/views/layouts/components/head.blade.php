<div class="nav-header">
    <a href="{{ url('/dashboard') }}" class="brand-logo">
{{--        <img class="logo-abbr" src="{{ url('vendor/dashboard/images/logo.png') }}" alt="">--}}
{{--        <img class="logo-compact" src="{{ url('vendor/dashboard/images/logo-text.png') }}" alt="">--}}
{{--        <img class="brand-title" src="{{ url('vendor/dashboard/images/logo-text.png') }}" alt="">--}}
        <img class="brand-title" src="{{ getImageUrlById(theme_option('logo'), 'shortcodes') }}" alt="">
    </a>

    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>
