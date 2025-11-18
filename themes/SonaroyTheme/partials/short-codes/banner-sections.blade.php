<section class="volunteer-section">
    <div class="volunteer-banner-section">
        <img src="{{ getImageUrlById($shortcode->image, 'shortcodes') }}" alt="{{ $shortcode->header_title }}">
        <div class="volunteer-gradient-overlay"></div>
        <div class="volunteer-banner-caption">
            <h4 class="caption-small-one">{{ $shortcode->header_title }}</h4>
            <h2>{{ $shortcode->contain }} <span class="first-color">{{ $shortcode->contain2 }}</span>  {{ $shortcode->contain3 }}</h2>
            @if($shortcode->button_label1)
                <div class="text-center">
                    <a href="{{ $shortcode->button_url1 }}" class="volunteer-block-button first-bg">{{ $shortcode->button_label1 }}</a>
                </div>
            @endif
        </div>
    </div>
</section>
