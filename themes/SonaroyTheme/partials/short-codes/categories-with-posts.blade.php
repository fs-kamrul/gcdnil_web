
@foreach($categories as $category)

    <div class="page_content mb_120">
        <h1 class="section_heading mb_65 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
            {{ $category->name }}
        </h1>
    @foreach($category->post as $key=>$post)
        @php
            $right = $key % 2;
                $path_post = 'uploads/post/';
                if($post->photo == ''){
                        $photo = 'vendor/kamruldashboard/images/image-not-found.png';
                    }else{
                        $photo = $path_post . $post->photo;
                    }
        @endphp
        <div class="page_box mb_100">
            <div class="row">
                @if(!$right)
                    <div class="col-lg-5">
                        <div class="img_part img_medium mb_45" data-aos="fade-in" data-aos-delay="200">
                            <img src="{{ url($photo) }}" alt="">
                        </div>
                    </div>
                @endif
                <div class="@if(!$right) offset-lg-1 @endif col-lg-6">
                    <div class="text_part">
                        <h6 class="menu_heading" data-aos="fade-up" data-aos-delay="200">{{ $post->name }}</h6>
                        <p class="mb_45 mt_26" data-aos="fade-up" data-aos-delay="300">{!! $post->description !!}</p>
                    </div>
                </div>
                @if($right)
                    <div class="@if($right) offset-lg-1 @endif col-lg-5">
                        <div class="img_part img_medium mb_45" data-aos="fade-in" data-aos-delay="200">
                            <img src="{{ url($photo) }}" alt="">
                        </div>
                    </div>
                @endif
            </div>
            @endforeach
        </div>
@endforeach

{{--<div class="site-bottom pt-50 pb-50">--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}
{{--            @foreach($categories as $category)--}}
{{--                <div class="col-lg-{{ 12 / count($categories) }} col-md-{{ 12 / (count($categories) + 1) }}">--}}
{{--                    <div class="sidebar-widget widget-latest-posts mb-30 wow fadeInUp  animated" style="visibility: visible; animation-name: fadeInUp;">--}}
{{--                        <div class="widget-header-2 position-relative mb-30">--}}
{{--                            <h5 class="mt-5 mb-30">{{ $category->name }}</h5>--}}
{{--                        </div>--}}
{{--                        <div class="post-block-list post-module-1">--}}
{{--                            <ul class="list-post">--}}
{{--                                @foreach($category->post as $posts)--}}
{{--                                    <li class="mb-30">--}}
{{--                                        <div class="d-flex hover-up-2 transition-normal">--}}
{{--                                            <div class="post-thumb post-thumb-80 d-flex mr-15 border-radius-5 img-hover-scale overflow-hidden">--}}
{{--                                                <a class="color-white" href="{{ $posts->slug }}">--}}
{{--                                                    <img src="{{ RvMedia::getImageUrl($post->image) }}" alt="{{ $post->name }}">--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="post-content media-body">--}}
{{--                                                <h6 class="post-title mb-15 text-limit-2-row font-medium"><a href="{{ $posts->slug }}">{{ $posts->name }}</a></h6>--}}
{{--                                                <div class="entry-meta meta-1 float-left font-x-small text-uppercase">--}}
{{--                                                    <span class="post-on">{{ $posts->created_at->translatedFormat('M d, Y') }}</span>--}}
{{--                                                    <span class="post-by has-dot">{{ number_format($posts->views) }} {{ __('views') }}</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!--container-->--}}
{{--</div>--}}
