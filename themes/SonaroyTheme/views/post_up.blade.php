@php
    $layout = MetaBox::getMetaData($post, 'layout', true);
    $layout = ($layout && in_array($layout, array_keys(get_blog_single_layouts()))) ? $layout : 'post-full-width';
    Theme::layout($layout);
//    dd($layout);
$columns = 'twelve';
if($layout == 'post-full-width'){
    $columns = 'sixteen';
}
@endphp
@php
    //    $right = $key % 2;
            $path_post = 'uploads/post/';
            $photo = getImageUrl($post->photo);
            if($post->document_file != ''){
                $photo_download = $path_post . $post->document_file;
            }else{
                $photo_download = '';
            }
//            dd(getImageUrl($post->document_file, ));
@endphp


@if($post->post_types->id == 6)
    @php
        $number_of_gallery = $post->PostGalleryParameter->count();
    @endphp
    @if($number_of_gallery)
        <div class="{{ $columns }} columns" id="left-content">
            <br>
            <hr id="print_div_hr">
        <section id="gallery" class="mb_150">
            <div class="container">
                <h3 class="section_heading">{{ $post->name }}</h3><br>
                <div class="gallery_main mt_35">
                    <div class="row gallery_row">
                        @foreach($post->PostGalleryParameter as $key=>$gallery)
                            @php
                                $odd_num = 0; if ($key % 2 == 0) { $odd_num = 1; }
                            @endphp
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <div class="gallery_img">
                                    <a href="{{ getImageUrl($gallery->name, 'post') }}" target="_blank"><img
                                            src="{{ getImageUrl($gallery->name, 'post') }}" alt="{{ $post->name }}"></a>

                                    <div class="overlay">
                                        <p>{{ $post->name }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        </div>
    @endif
@else
    {{--    twelve--}}
    <div class="{{ $columns }} columns" id="left-content">
        <br>
        <hr id="print_div_hr">
        <h3 class="mt_45">{{ $post->name }}</h3>
        <div class="details_main mt_45 ">
            <div class="details_img">
                <img src="{{ $photo }}" alt="{{ $post->name }}">
            </div>
            <div class="details_text raper_text">
                <p class="">{!! $post->description !!}</p>
                @if($post->document_file)
                    <a class="btn document_file" download="" href="{{ getImageUrl($post->document_file, ) }}">@lang('Download')</a>
                @endif
            </div>
        </div>
    </div>
@endif

@if($post->post_types->id != 6)
    @php
        $number_of_gallery = $post->PostGalleryParameter->count();
    @endphp
    @if($number_of_gallery)
        <div class="news_events_blog_gallery mt_75">
            <div class="row ">
                @foreach($post->PostGalleryParameter as $key=>$gallery)
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
                        <div class="news_events_blog_gallery_img mb_24">
                            <img src="{{ getImageUrl($gallery->name, 'post') }}" alt="{{ $post->name }}">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endif
@php
    $relatedPosts = get_related_posts($post->id, 3);
@endphp
@if($relatedPosts->count())
    <div class="{{ $columns }} columns mb_100" id="left-content">
    <div id="news_events" class="mt_150 mb_150">
        <div class="container">
                @php
                    $category = '';
                    foreach($post->categories as $value) {
                        $category .= $value->name . ', '; //like this
                    }
                @endphp
            <div class="news_events_top">
                <h3 class="mt_45">@lang('Explore More') {{ rtrim($category, ", ") }}</h3>
{{--                <a class="outline_btn" href="#">@lang('Learn More')</a>--}}
            </div>
            <div class="new_event_main">
                @include(Theme::getThemeNamespace() . '::views.venue.includes.news-items', ['posts' => $relatedPosts])
{{--                @foreach($relatedPosts as $key => $relatedPost)--}}
{{--                    <div class="more_venue_item">--}}
{{--                        <div class="main_venue_img">--}}
{{--                            <img src="{{ getImageUrl($relatedPost->photo) }}" alt="{{ $relatedPost->name }}">--}}
{{--                        </div>--}}

{{--                        <h2 class="sub_heading_30 blue_text mt_45">{{ $relatedPost->name }}</h2>--}}
{{--                        <p class="mt_30">{!! $relatedPost->description !!}</p>--}}
{{--                        <a href="{{ url($relatedPost->url) }}" class="outline_btn mt_30">@lang('Learn More')</a>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
            </div>
        </div>
    </div>
    </div>
@endif
