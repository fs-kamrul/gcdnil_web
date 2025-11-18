
@foreach($posts as $key => $post)
    @php
    $right = $key % 2;
        $path_post = 'uploads/post/';
        if($post->photo == ''){
                $photo = 'vendor/kamruldashboard/images/image-not-found.png';
            }else{
                $photo = $path_post . $post->photo;
            }
    @endphp
{{--    <div class="col-md-{{ Theme::getLayoutName() == 'right-sidebar' ? 6 : 4 }} mb-40">--}}
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
            </div>
@endforeach

<div class="pagination-area mb-30 wow fadeInUp animated justify-content-start">
    {!! $posts->withQueryString()->onEachSide(1)->links() !!}
</div>
<!-- --------------- Laboratory End --------------- -->
