@php
//    Theme::asset()->container('footer')->usePath()->add('jquery.theia.sticky-js', 'js/library/jquery.theia.sticky.js');
@endphp

{!! Theme::partial('header') !!}

<section id="course_page">
    @if (Theme::get('hasBreadcrumb', true))
        {!! Theme::partial('breadcrumbs') !!}
    @endif
    <div class="course_main">
        <div class="container">
            <div class="row">
{{--                <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-sm-12">--}}
                    {!! Theme::content() !!}
{{--                </div>--}}
{{--                <div class="offset-xxl-1 col-xxl-4 offset-xl-1 col-xl-4 offset-lg-1 col-lg-4 col-md-12 col-sm-12">--}}
{{--                    <div class="widget-area">--}}
                        {!! dynamic_sidebar('product_sidebar') !!}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
</section>>

{!! Theme::partial('footer') !!}
