
<section class="news-single section wow fadeIn" data-wow-delay="0.3s">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="single-main">
                            <!-- News Head -->
                            <div class="news-head">
                                <img src="{{ getImageUrl($event->photo, 'adminboard/adminevent') }}" alt="{{ $event->name }}">
                            </div>
                            <!-- News Title -->
{{--                            <h1 class="news-title"><a href="{{ $event->url }}">{{ $event->name }}</a></h1>--}}
                            <!-- Meta -->
                            <div class="meta">
                                <div class="meta-left">
                                    <span class="date"><i class="ri-news-line"></i>{{ date('d M Y', strtotime($event->start_date)) }}</span>
                                </div>
                                <div class="meta-right">
                                    <span class="comments"><a ><i class="fa fa-clock-o"></i> {{ $event->set_time }}</a></span>
                                </div>
                            </div>
                            <!-- News Text -->
                            <div class="news-text">
                                <p>{!! $event->description !!}</p>
                                {{--                                <div class="image-gallery">--}}
                                {{--                                    <div class="row wow fadeInUp" data-wow-delay="0.3s">--}}
                                {{--                                        <div class="col-lg-6 col-md-6 col-12">--}}
                                {{--                                            <div class="single-image">--}}
                                {{--                                                <img src="img/blog2.jpg" alt="#">--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="col-lg-6 col-md-6 col-12">--}}
                                {{--                                            <div class="single-image">--}}
                                {{--                                                <img src="img/blog3.jpg" alt="#">--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                            </div>
                            <div class="blog-bottom">
                                <!-- Social Share -->
                                <ul class="social-share">
                                    <li class="facebook"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}&title={{ strip_tags(SeoHelper::getDescription()) }}"><i class="fa fa-facebook"></i><span>Facebook</span></a></li>
                                    <li class="twitter"><a target="_blank" href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ strip_tags(SeoHelper::getDescription()) }}"><i class="fa fa-twitter"></i><span>Twitter</span></a></li>
                                    {{--                                    <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>--}}
                                    <li class="linkedin"><a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&summary={{ rawurldecode(strip_tags(SeoHelper::getDescription())) }}"><i class="fa fa-linkedin"></i></a></li>
                                    {{--                                    <li class="pinterest"><a href="#"><i class="fa fa-pinterest"></i></a></li>--}}
                                </ul>
                                <!-- Next Prev -->
                                {{--                                <ul class="prev-next">--}}
                                {{--                                    <li class="prev"><a href="#"><i class="fa fa-angle-double-left"></i></a></li>--}}
                                {{--                                    <li class="next"><a href="#"><i class="fa fa-angle-double-right"></i></a></li>--}}
                                {{--                                </ul>--}}
                                <!--/ End Next Prev -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Single Blog -->
            <div class="col-lg-4 col-12">
                <div class="main-sidebar">
                    <!-- Single Widget -->
                    <div class="single-widget search">
                        <div class="form">
                            <input type="email" placeholder="Search Here...">
                            <a class="button" href="#"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
{{--                    <div class="single-widget category wow fadeInUp" data-wow-delay="0.3s">--}}
{{--                        <h3 class="title">@lang('post::lang.category')</h3>--}}
{{--                        {!! Theme::partial('blog_categories', ['categories' => $categories, 'options' => ['class' => 'categor-list'] ]) !!}--}}
{{--                    </div>--}}
                    {!! Theme::partial('adminboard_recent', ['posts' => $events, 'photo' => 'adminboard/adminevent']) !!}
                    {{--                    <div class="single-widget side-tags wow fadeInUp" data-wow-delay="0.7s">--}}
                    {{--                        <h3 class="title">Tags</h3>--}}
                    {{--                        <ul class="tag">--}}
                    {{--                            <li><a href="#">June 2024</a></li>--}}
                    {{--                            <li><a href="#">October 2023</a></li>--}}
                    {{--                            <li><a href="#">September 2023</a></li>--}}
                    {{--                            <li><a href="#">August 2023</a></li>--}}
                    {{--                        </ul>--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</section>
