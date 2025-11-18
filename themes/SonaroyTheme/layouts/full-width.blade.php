{!! Theme::partial('header') !!}

<div class="sixteen columns mb_100" id="left-content">
    <br>
    <hr id="print_div_hr">
    <h1 class="section_heading">{{ SeoHelper::getTitle() }}</h1>
    {{--        <p class="mt_35">--}}
    {{--        </p>--}}
    {!! Theme::content() !!}
</div>

{!! Theme::partial('footer') !!}
