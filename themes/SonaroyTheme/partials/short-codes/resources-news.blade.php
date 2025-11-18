
<!-- --------------------- News Resources Start --------------------- -->
<section id="news_resources">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="news_top">
                    <h3 class="section_heading primary_text center_text">Resources & News</h3>
                </div>
            </div>
        </div>

        <div class="news_resources_main mt_80">
            <div class="row">
                @foreach($posts as $key=>$post)
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
                    <div class="news_wrapper">
                        <div class="news_img">
                            <div class="overlay">
                                <div class="overlay">
                                    <a href="#">Design</a>
                                </div>
                            </div>
                            @php
                                if($post->photo){
                                    $image = getImageUrl($post->photo);
                                }else{
                                    $image = getDefaultImage();
                                }
                            @endphp
                            <img src="{{ $image }}" alt="{{ $post->name }}">
                        </div>

                        <div class="news_details">
                            <a href="{{ $post->url }}" class="news_title">{{ description_summary($post->name) }}</a>

                            <div class="event_date_time">
                                <div class="event_date_time_icon">
                                    <img src="{{ url('themes/'. Theme::getThemeName() .'/img/calendar.png') }}" alt="Event Date">
                                </div>
                                @php
                                    $start_date = $post->start_date;
                                    $formatted_date = date('d M Y', strtotime($start_date));
                                @endphp
                                <p class="heading_16">{{ $formatted_date }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @if($shortcode->button_url && $shortcode->button_label)
        <div class="center_text mt_110">
            <a href="{{ $shortcode->button_url }}" target="_blank" class="btn_blue_bold">{{ $shortcode->button_label }}</a>
        </div>
        @endif
    </div>
</section>
<!-- --------------------- News Resources End --------------------- -->
