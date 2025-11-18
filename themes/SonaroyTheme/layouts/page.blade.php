{!! Theme::partial('header') !!}

{{--{!! Theme::content() !!}--}}
{{--<section id="course_page">--}}

{{--    @if (Theme::get('hasBreadcrumb', true))--}}
{{--        {!! Theme::partial('breadcrumbs') !!}--}}
{{--    @endif--}}
<div class="sixteen columns mb_100" id="left-content">
    <br>
    <hr id="print_div_hr">
    {{--        <p class="mt_35">--}}
    {{--        </p>--}}
    {!! Theme::content() !!}
</div>

{!! Theme::partial('footer') !!}
