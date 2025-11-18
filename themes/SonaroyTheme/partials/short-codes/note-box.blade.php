<!-- ----------------------- Reserve venue Start ----------------------- -->
<section id="reserve_venue">
    <div class="container">
        <div class="reserve_venue_main">
            <h6 class="section_heading">{{ $shortcode->title }}</h6>
            <p>{{ $shortcode->contain }}</p>
            @if($shortcode->button_label1)
                <div class="text-center">
                    <a href="{{ $shortcode->button_url1 }}" class="green_outline_btn">{{ $shortcode->button_label1 }}</a>
                </div>
            @endif
        </div>
    </div>
</section>
