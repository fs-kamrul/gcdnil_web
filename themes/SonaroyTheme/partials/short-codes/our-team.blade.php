<!-- Team Start -->
<div class="container-xxl py-5">
    <div class="container py-5">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="text-secondary text-uppercase">{{ $post_types->name }}</h6>
            <h1 class="mb-5">{{ $shortcode->title }}</h1>
        </div>
        <div class="row g-4">

            @foreach($post_types->post as $post)
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="team-item p-4">
                    <div class="overflow-hidden mb-4">
                        @php
                            $photo= getImageUrl($post->photo, 'post');
                        @endphp
                        <img class="img-fluid" src="{{ $photo }}" alt="{{ $post->name }}">
                    </div>
                    <h5 class="mb-0">{{ $post->name }}</h5>
                    <p>{{ $post->designation }}</p>
                    <div class="btn-slide mt-1">
                        <i class="fa fa-share"></i>
                        <span>
                                <a href=""><i class="fab fa-facebook-f"></i></a>
{{--                                <a href=""><i class="fab fa-twitter"></i></a>--}}
{{--                                <a href=""><i class="fab fa-instagram"></i></a>--}}
                            </span>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
<!-- Team End -->
