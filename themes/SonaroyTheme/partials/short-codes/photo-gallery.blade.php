<!-- ----------------------- Different Start ----------------------- -->

@isset($post_types->post)
    @if($post_types->post != null)
        <section id="gallery_main_page" class="mb_150">
            <div class="container">
                <h1 class="section_heading">{{ $shortcode->title }}</h1>

                <div class="row mt_45">
                    @foreach($post_types->post as $key=>$post)
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
                            <div class="gallery_folder">
                                <a href="{{ $post->url }}">
                                    <img src="{{ getImageUrl($post->photo) }}" alt="{{ $post->name }}"/>
                                </a>

                                <span>
                                    <a href="{{ $post->url }}">@lang('See More')</a>
                                </span>

                                <div class="overlay">
                                    <p>{{ $post->name }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endisset
<!-- ----------------------- Different End ----------------------- -->
