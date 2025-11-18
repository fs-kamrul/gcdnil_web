<!-- Start Partner Section -->
<section>
    <div class="partner-section">
        <div class="section-header-wrapper">
            <h2 class="section-header">{{ $shortcode->title }}</h2>
        </div>
        <div class="partner-logo-container">
            @foreach($post_types->post as $post)
                <div class="logo_box">
                    <img class="partner-logo" src="{{ getImageUrl($post->photo) }}" alt="{{ $post->name }}">
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- End Partner Section -->
