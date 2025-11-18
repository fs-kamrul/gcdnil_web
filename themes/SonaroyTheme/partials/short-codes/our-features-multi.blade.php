<!-- Start Our Facilities Sections -->
<section class="our-facilities section-padding">
    <div class="container">
        <div class="section-header-wrapper">
            <div class="section-header">
                <h2>{{ $shortcode->title }}</h2>
            </div>
            @if($shortcode->button_label1)
                <a class="border-button" href="{{ $shortcode->button_url1 }}">{{ $shortcode->button_label1 }}</a>
            @endif
        </div>
        <div class="row">
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-4 mb-lg-0">
                <div class="facilities-content">
                    <h2>{{ $shortcode->contain }}</h2>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-4 mb-lg-0">

                @foreach($post_types->post as $post)
                <div class="facilities-item d-flex text-center">
                    <div class="facilities-hero-bg">
                        <img src="{{ getImageUrl($post->icon_set) }}" alt="{{ $post->name }}">
                    </div>
                    <h5>{{ $post->name }}</h5>
                </div>
                @endforeach
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="row">
                    @php
                        $data_photo= $shortcode->pics_file;
                        $data_photo = explode(',', $data_photo);
                    @endphp
                    @foreach($data_photo as $image)
                    <div class="col-lg-6 col-sm-6">
                        <div class="facilities-gallery mb-4">
                            <img src="{{ getImageUrlById($image, 'shortcodes') }}" alt="Image">
                        </div>
                    </div>
                    @endforeach
{{--                </div>--}}
{{--                <div class="row">--}}
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Our Facilities Sections -->
