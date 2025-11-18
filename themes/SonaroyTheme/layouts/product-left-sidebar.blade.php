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
                    {!! Theme::content() !!}
                <div class="col-lg-3 primary-sidebar sticky-sidebar">
                    <div class="widget-area">
                        {!! dynamic_sidebar('product_sidebar') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{!! Theme::partial('footer') !!}
