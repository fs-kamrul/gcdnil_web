<!-- About Start -->
<section class="about-section section-padding">
    <div class="container">
        <div class="row flex-direction-md">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 flex-direction-md">
                <div class="about-image">

                    @foreach($post_types->post as $post)
                        @if($post->photo)
                            <img class="" src="{{ getImageUrl($post->photo) }}" alt="{{ $post->name }}">
                            @break
                        @endif
                    @endforeach
                </div>
                <div class="our-quality">
                    @foreach($post_types->post as $post)
                        <div class="about-content">
                            <div class="about-item d-flex text-center">
                                <div class="about-hero-bg">
                                    <img src="{{ getImageUrl($post->icon_set) }}" alt="{{ $post->name }}">
                                </div>
                                <h5>{{ $post->name }}</h5>
                            </div>
                            {!! $post->description !!}
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="about-container">
                    <div class="about-main-content">
                        <div class="section-header">
                            <h2>{{ $shortcode->title }}</h2>
                        </div>
                        <div class="about-description">
                            <p>{{ $shortcode->description }}</p>
                        </div>
                        <div class="about-button">
                            @if($shortcode->button_label1)
                                <a href="{{ $shortcode->button_url1 }}" class="block-button">{{ $shortcode->button_label1 }}</a>
                            @endif
                            @if($shortcode->button_label2)
                                <a href="{{ $shortcode->button_url2 }}" class="border-button">{{ $shortcode->button_label2 }}</a>
                            @endif
                        </div>
                    </div>
                    <div class="about-image">
                        <img class="" src="{{ getImageUrlById($shortcode->image, 'shortcodes') }}" alt="{{ $shortcode->title }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
