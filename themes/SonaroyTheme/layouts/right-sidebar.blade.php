{!! Theme::partial('header') !!}

<div id="contents" class="sixteen columns">
    <div class="twelve columns" id="left-content">
        <div class="container-fluid">
        <div class="row mainwrapper">
            <div class="sixteen columns mb_100" id="left-content">
                <br>
                <hr id="print_div_hr">
                <h1 class="section_heading">{{ SeoHelper::getTitle() }}</h1>
                {{--        <p class="mt_35">--}}
                {{--        </p>--}}
                {!! Theme::content() !!}
            </div>
        </div>
        </div>
    </div>
    <div class="four columns right-side-bar mt-3" id="right-content">
        {!! dynamic_sidebar('product_sidebar') !!}
    </div>
</div>

{!! Theme::partial('footer') !!}
