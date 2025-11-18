<!-- Carousel Start -->
<div class="container-fluid p-0 pb-5">
    <div class="owl-carousel header-carousel position-relative mb-5">
        @foreach($sliders as $slider)
        <div class="owl-carousel-item position-relative">
            <img class="img-fluid img-fluid-slider" src="{{ getImageUrlById($slider->image,'shortcodes') }}" alt="image">
            <div class="position-absolute owl-carousel-bg-color top-0 start-0 w-100 h-100 d-flex align-items-center">
                <div class="container">
                    <div class="row justify-content-start">
                        {!! Theme::partial('short-codes.sliders.content', compact('slider')) !!}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Carousel End -->
{{--<div class="hero-slider-1 dot-style-1 dot-style-1-position-1 {{ $class ?? ''}}" data-autoplay="{{ $shortcode->is_autoplay ?: 'yes' }}" data-autoplay-speed="{{ in_array($shortcode->autoplay_speed, theme_get_autoplay_speed_options()) ? $shortcode->autoplay_speed : 3000 }}">--}}
{{--    @foreach($sliders as $slider)--}}
{{--        <div class="single-hero-slider single-animation-wrap">--}}
{{--            <div class="container">--}}
{{--                <div class="row align-items-center slider-animated-1">--}}
{{--                    <div class="col-lg-5 col-md-6">--}}
{{--                        {!! Theme::partial('short-codes.sliders.content', compact('slider')) !!}--}}
{{--                    </div>--}}
{{--                    <div class="col-lg-7 col-md-6">--}}
{{--                        <div class="single-slider-img single-slider-img-1">--}}
{{--                            <img class="animated" src="{{ getImageUrlById($slider->image,'shortcodes') }}" alt="image">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endforeach--}}
{{--</div>--}}
{{--<div class="slider-arrow hero-slider-1-arrow"></div>--}}
