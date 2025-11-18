{!! Theme::partial('header') !!}


<div id="contents" class="sixteen columns">
    <div class="twelve columns" id="left-content">
        <div class="row mainwrapper">
            {!! Theme::content() !!}
        </div>
    </div>
    <div class="four columns right-side-bar" id="right-content">
        {!! dynamic_sidebar('product_sidebar') !!}
    </div>
</div>

{!! Theme::partial('footer') !!}
