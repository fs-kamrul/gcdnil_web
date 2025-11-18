<!-- ----------------------- Different Start ----------------------- -->
@isset($post_types->post)
@if($post_types->post != null)
<section id="different">
    <div class="different_wrapper">
        <div class="container">
            <div class="different_top">
                <h5 class="section_heading">{{ $shortcode->title }}</h5>
            </div>
            <div class="different_main">
                @foreach($post_types->post as $key=>$post)
                <div class="different_box">
                    <div class="different_icon">
                        <img src="{{ getImageUrl($post->photo) }}" alt="{{ $post->name }}">
                    </div>

                    <h6 class="sub_heading_26">{{ $post->name }}</h6>
                    <p class="font_pop">{{ $post->short_description }}</p>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>
@endif
@endisset
<!-- ----------------------- Different End ----------------------- -->
