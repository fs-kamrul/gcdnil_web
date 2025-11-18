@if ($post)
    <div class="all_venue_box mb_85">
        <div class="all_venue_img">
            <img src="{{ getImageUrl($post->photo, 'post') }}" alt="{{ $post->name }}">
        </div>

        <h2 class="sub_heading_30 mt_45">{{ $post->name }}</h2>

        <p class="mt_30">{!! $post->description !!}</p>

        <a href="{{ $post->url }}" class="outline_btn mt_30">@lang('Learn More')</a>
    </div>
@endif
