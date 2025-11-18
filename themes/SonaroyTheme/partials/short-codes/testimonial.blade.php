<section class="feedback section-padding">
    <div class="container">
        <div class="section-header-wrapper">
            <div class="section-header">
                <h2>{{ $shortcode->title }}</h2>
            </div>
            @if($shortcode->button_label)
                <a class="border-button" href="{{ $shortcode->button_url }}">{{ $shortcode->button_label }}</a>
            @endif
        </div>
        <!-- Swiper -->
        <div class="feedback-slider">
            <div class="row">
                <div
                    class="offset-xxl-1 col-xxl-10 offset-xl-1 col-xl-10 offset-lg-1 col-lg-10 offset-md-1 col-md-10 col-sm-12">
                    <div class="swiper parentsfeedback">
                        <div class="swiper-wrapper">
                            @foreach($post_types->post as $post)
                            <div class="swiper-slide">
                                <div class="parents-feedback">
                                    <div class="row">
                                        <div class="col-md-4 col-md-4 mx-auto">
                                            <img src="{{ getImageUrl($post->photo) }}" alt="Parents Feedback">
                                        </div>
                                        <div class="col-md-8 mx-auto my-auto">
                                            <div class="feedback-details">
                                                <div class="feedback-content">
                                                    <p>{!! $post->description !!}</p>
                                                </div>
                                                <div class="parents-details">
                                                    <h6>{{ $post->name }}, <br>{{ $post->designation }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-button-next"><i class="fa-solid fa-chevron-right"></i></div>
            <div class="swiper-button-prev"><i class="fa-solid fa-chevron-left"></i></div>
        </div>
    </div>
</section>

