<section class="campus-activity section-padding">
    <div class="container">
        <div class="section-header-wrapper">
            <div class="section-header">
                <h2>{{ $shortcode->title }}</h2>
            </div>
            @if($shortcode->button_label1)
                    <a href="{{ $shortcode->button_url1 }}" class="border-button">{{ $shortcode->button_label1 }}</a>
            @endif
        </div>
        <!-- Swiper -->
        <div class="swiper ouractivity">
            <div class="swiper-wrapper">
                @foreach($post_types->post as $post)
                <div class="swiper-slide">
                    <div class="activity-item">
                        <img src="{{ getImageUrl($post->photo) }}" alt="{{ $post->name }}">
                        <div class="activity-content">
                            <a href="{{ $post->url }}">{{ $post->name }}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-button-next"><i class="fa-solid fa-chevron-right"></i></div>
            <div class="swiper-button-prev"><i class="fa-solid fa-chevron-left"></i></div>
        </div>
    </div>
</section>
