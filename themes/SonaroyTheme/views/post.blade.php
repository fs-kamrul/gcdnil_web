@php
    $layout = MetaBox::getMetaData($post, 'layout', true);
    $layout = ($layout && in_array($layout, array_keys(get_blog_single_layouts()))) ? $layout : 'post-full-width';
    Theme::layout($layout);
@endphp
@php
//    $right = $key % 2;
        $path_post = 'uploads/post/';
        if($post->photo == ''){
            $photo = 'vendor/kamruldashboard/images/image-not-found.png';
        }else{
            $photo = $path_post . $post->photo;
        }
        if($post->document_file != ''){
            $photo_download = $path_post . $post->document_file;
        }else{
            $photo_download = '';
        }
@endphp
<section id="page_post">
    <div class="container">

        @if (Theme::get('hasBreadcrumb', true))
            {!! Theme::partial('breadcrumbs') !!}
        @endif
{{--        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="page_breadcrumb" data-aos="fade-in" data-aos-delay="200">--}}
{{--            {!! Theme::breadcrumb()->render() !!}--}}
{{--        </nav>--}}

        <div class="page_content mb_120">
{{--            <h1 class="section_heading mb_65" data-aos="fade-up" data-aos-delay="100">English Medium</h1>--}}

            <div class="page_box mb_100">

                <div class="row">
                    <div class="col-lg-5">
                        <div class="img_part img_medium mb_45" data-aos="fade-in" data-aos-delay="200">
                            <img src="{{ url($photo) }}" alt="">
                        </div>
                    </div>
                    <div class="offset-lg-1 col-lg-6">
                        <div class="text_part">
                            <h6 class="menu_heading" data-aos="fade-up" data-aos-delay="200">{{ $post->name }}</h6>
                            <p class="mb_45 mt_26" data-aos="fade-up" data-aos-delay="300">
                                {!! $post->description !!}
                            </p><br/>
                            @if($photo_download != '')
                            <div class="apply_btn mb_60" data-aos="fade-up" data-aos-delay="300">
                                <a href="{{ url($photo_download) }}" class="regular_btn blue_btn" download>@lang('Download')</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @php
                    $relatedPosts = get_related_posts($post->id, 4);
                @endphp

                @foreach($relatedPosts as $key => $relatedPost)
                    @php
                        $right = $key % 2;
                            $path_post = 'uploads/post/';
                            if($relatedPost->photo == ''){
                                    $photo2 = 'vendor/kamruldashboard/images/image-not-found.png';
                                }else{
                                    $photo2 = $path_post . $relatedPost->photo;
                                }
                    @endphp
                    {{--    <div class="col-md-{{ Theme::getLayoutName() == 'right-sidebar' ? 6 : 4 }} mb-40">--}}
                    <div class="page_box mb_100">
                        <div class="row">
                            @if($right)
                                <div class="col-lg-5">
                                    <div class="img_part img_medium mb_45" data-aos="fade-in" data-aos-delay="200">
                                        <img src="{{ url($photo2) }}" alt="{{ $relatedPost->name }}">
                                    </div>
                                </div>
                            @endif
                            <div class="@if($right) offset-lg-1 @endif col-lg-6">
                                <div class="text_part">
                                    <h6 class="menu_heading" data-aos="fade-up" data-aos-delay="200">{{ $relatedPost->name }}</h6>
                                    <p class="mb_45 mt_26" data-aos="fade-up" data-aos-delay="300">{!! $relatedPost->description !!}</p>
                                </div>
                            </div>
                            @if(!$right)
                                <div class="@if(!$right) offset-lg-1 @endif col-lg-5">
                                    <div class="img_part img_medium mb_45" data-aos="fade-in" data-aos-delay="200">
                                        <img src="{{ $photo2 }}" alt="{{ $relatedPost->name }}">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

