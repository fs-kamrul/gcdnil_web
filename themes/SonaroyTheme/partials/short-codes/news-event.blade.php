<!-- ----------------------- News & Events Start ----------------------- -->
<section id="news_events" class="home_news_events">
    <div class="container">
        <div class="news_events_top">
            <h4 class="section_heading">{{ $shortcode->title }}</h4>
            @if($shortcode->button_label1)
                <a class="outline_btn" href="{{ $shortcode->button_url1 }}">{{ $shortcode->button_label1 }}</a>
            @endif
        </div>

        <div class="new_event_main">
            @php
                $posts = $post_types->post;
            @endphp
            @include(Theme::getThemeNamespace() . '::views.venue.includes.news-items', compact('posts'))
        </div>
    </div>
</section>
<!-- ----------------------- News & Events End ----------------------- -->
