
<!-- --------------------- Testimonial Start --------------------- -->
<section id="testimonial_page">
    <div class="container">
        <div class="testi_top">
            <div class="row">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="left_part">
                        <span class="span_block section_heading">{{ $shortcode->title }}</span>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="right_part">
                        <div class="data_part">
                            <div class="banner_data_box">
                                <div class="banner_data_img">
                                    <img src="{{ url('themes/'. Theme::getThemeName() .'/img/data-student.png') }}">
                                </div>

                                <div class="banner_data_info">
                                    <h6 class="heading_30">{{ theme_option('action_students_text') }}</h6>
                                    <p>@lang('Students')</p>
                                </div>
                            </div>
                        </div>

                        <div class="data_part">
                            <div class="banner_data_box">
                                <div class="banner_data_img">
                                    <img src="{{ url('themes/'. Theme::getThemeName() .'/img/data-teacher.png') }}">
                                </div>

                                <div class="banner_data_info">
                                    <h6 class="heading_30">{{ theme_option('action_teachers_text') }}</h6>
                                    <p>@lang('Teachers')</p>
                                </div>
                            </div>
                        </div>

                        <div class="data_part">
                            <div class="banner_data_box">
                                <div class="banner_data_img">
                                    <img src="{{ url('themes/'. Theme::getThemeName() .'/img/data-materials.png') }}">
                                </div>

                                <div class="banner_data_info">
                                    <h6 class="heading_30">{{ theme_option('action_materials_text') }}</h6>
                                    <p>@lang('Materials')</p>
                                </div>
                            </div>
                        </div>

                        <div class="data_part">
                            <div class="banner_data_box">
                                <div class="banner_data_img">
                                    <img src="{{ url('themes/'. Theme::getThemeName() .'/img/data-subjects.png') }}">
                                </div>

                                <div class="banner_data_info">
                                    <h6 class="heading_30">{{ theme_option('action_subjects_text') }}</h6>
                                    <p>@lang('Subjects')</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="testi_main mt_110">
            @foreach($posts as $post)
            <div class="t_box">
                <div class="t_box_top">
                    <div class="testi_info">
                        <div class="testimonial_img_box">
                            @php
                                if($post->photo){
                                    $image = getImageUrl($post->photo);
                                }else{
                                    $image = getDefaultImage();
                                }
                            @endphp
                            <img src="{{ $image }}" alt="{{ $post->name }}">
                        </div>

                        <div class="t_details">
                            <h6 class="heading_18">{{ $post->name }}</h6>
                            <p class="testi_job">{{ $post->designation }}</p>
                        </div>
                    </div>
                </div>

                <div class="testi_quote">
                    <p class="mt_40">{!! $post->description !!}</p>
                </div>
                <img class="testi_quote_img" src="{{ url('themes/'. Theme::getThemeName() .'/img/icon-quote.png') }}">
            </div>
            @endforeach
        </div>
    </div>

    @if ($posts->total() > 0)
        <div class="mb_100 mt_80">
            {!! $posts->withQueryString()->onEachSide(1)->links(Theme::getThemeNamespace() . '::partials.custom-pagination') !!}
        </div>
    @endif
</section>
<!-- --------------------- Testimonial End --------------------- -->
