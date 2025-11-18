<!-- ----------------------- Different Start ----------------------- -->
@isset($post_types->post)
@if($post_types->post != null)
    <section id="all_facilities" class="mt_150">
        <div class="container">
            <h3 class="section_heading">{{ $shortcode->title }}</h3>
            @foreach($post_types->post as $key=>$post)
                @php
                    $odd_num = 0; if ($key % 2 == 0) { $odd_num = 1; }
                @endphp
                <div class="all_facility_box mt_45 mb_150">
                    <div class="row col-reverse">
                        @if($odd_num == 1)
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="facility_img">
                                    <img src="{{ getImageUrl($post->photo) }}" alt="{{ $post->name }}">
                                </div>
                            </div>
                        @endif
                        <div class=" @if($odd_num == 1) offset-xxl-1 col-xxl-5 offset-xl-1 col-xl-5 col-lg-6 col-md-12 col-sm-12 @else col-xxl-5 col-xl-5 col-lg-6 col-md-12 col-sm-12 @endif">
                            <div class="facility_text">
                                <h4 class="sub_heading_30 blue_text">{{ $post->name }}</h4>
                                <p class="mt_35">{!! $post->description !!}</p>
                            </div>
                        </div>
                        @if($odd_num == 0)
                            <div class="offset-xxl-1 col-xxl-6 offset-xl-1 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="facility_img">
                                    <img src="{{ getImageUrl($post->photo) }}" alt="{{ $post->name }}">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif
@endisset
<!-- ----------------------- Different End ----------------------- -->
