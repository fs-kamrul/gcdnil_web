<!-- ----------------------- Venues Start ----------------------- -->
<section id="venues">
    <div class="container">
        <div class="venues_top">
            <h4 class="section_heading">{{ $shortcode->title }}</h4>
            @if($shortcode->button_label1)
                <a class="outline_btn" href="{{ $shortcode->button_url1 }}">{{ $shortcode->button_label1 }}</a>
            @endif
        </div>
    </div>

    <div class="venues_main">
        <div class="venue_box">
            @foreach($post_types->post as $key=>$post)
                @php
                $odd = $key % 2;
//                print_r($odd);
                @endphp
                <div class="@if($odd == 0) venue_img_small @else venue_img_big @endif">
                    <img src="{{ getImageUrl($post->photo) }}" alt="{{ $post->name }}">
                    <div class="overlay">
                        <h6 class="sub_heading_26">{{ $post->name }}</h6>
                        <p>{{ $post->short_description }}</p>
                        <a href="{{ $post->url }}" class="overlay_btn">@lang('Learn More')</a>
                    </div>
                </div>
                @if($odd == 1)
        </div>

                    @if($post_types->post->count() != $key+1)
        <div class="venue_box">
                    @endif
                @endif
            @endforeach
        </div>

    </div>
</section>
<!-- ----------------------- Venues End ----------------------- -->


