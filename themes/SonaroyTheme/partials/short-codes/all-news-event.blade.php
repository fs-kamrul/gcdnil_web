
<div class="sixteen columns mb_100" id="left-content">
<div id="news_events" class="mt_150 mb_150">
    <div class="container">
        <div class="news_events_top">
            <h3 class="mt_45">{{ $shortcode->title }}</h3>

            @if($shortcode->button_label1)
                <a class="outline_btn" href="{{ $shortcode->button_url1 }}">{{ $shortcode->button_label1 }}</a>
            @endif
            {{--                <a class="outline_btn" href="#">@lang('Learn More')</a>--}}
        </div>

        <div class="new_event_main">
            @include(Theme::getThemeNamespace() . '::views.venue.includes.news-items', compact('posts'))
        </div>
        @if ($posts->total() > 0)
            {!! $posts->links(Theme::getThemeNamespace() . '::partials.pagination') !!}
        @endif
    </div>
</div>
</div>
