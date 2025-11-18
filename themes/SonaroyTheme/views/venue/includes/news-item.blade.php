@if ($post)
    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
        <div class="news_event_box mb_24">
            <div class="new_event_img">
                <img src="{{ getImageUrl($post->photo) }}" alt="{{ $post->name }}">
{{--                <div class="new_event_date">--}}
{{--                    <div class="date date_text">--}}
{{--                        {{ date("d",strtotime($post->start_date)) }}--}}
{{--                    </div>--}}
{{--                    <div class="month date_text">--}}
{{--                        {{ date("m",strtotime($post->start_date)) }}--}}
{{--                    </div>--}}
{{--                    <div class="year date_text">--}}
{{--                        {{ date("y",strtotime($post->start_date)) }}--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>

            <div class="new_events_info">
                <h4 class="news_events_title"><a href="{{ $post->url }}">{{ description_summary($post->name, 50) }}</a><i
                        class="ri-arrow-right-up-line"></i></h4>
                <p class="news_events_details">{!! $post->description !!}</p>
            </div>
        </div>
    </div>
@endif
