
    <!-- --------------------- Testimonial Start --------------------- -->
    <section class="affiliations section-padding">
        <div class="container">
            <div class="section-header-wrapper">
                <div class="section-header">
                    <h2>{{ $shortcode->title }}</h2>
                </div>
            </div>
            <div class="swiper affiliation-slider">
                <div class="swiper-wrapper affiliations-container">
                    @foreach($post_types->post as $post_type)
                    <div class="swiper-slide affiliations-logo mb-5 mb-lg-0">
                        <img src="{{ getImageUrl($post_type->photo) }}" alt="{{ $post_type->name }}">
                    </div>
                    @endforeach
                </div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </section>
    <!-- --------------------- Testimonial End --------------------- -->
