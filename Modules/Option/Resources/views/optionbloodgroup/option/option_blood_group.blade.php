
<section class="news-single section wow fadeIn" data-wow-delay="0.3s">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="single-main">
                            <!-- News Head -->
                            <div class="news-head">
                                <img src="{{ getImageUrl($option_blood_group->photo, 'adminboard/optionbloodgroup') }}" alt="{{ $option_blood_group->name }}">
                            </div>
                            <!-- News Title -->
{{--                            <h1 class="news-title"><a href="{{ $option_blood_group->url }}">{{ $option_blood_group->name }}</a></h1>--}}
                            <!-- Meta -->
                            <div class="meta">
                                <div class="meta-left">
                                    <span class="date"><i class="ri-news-line"></i>{{ date('d M Y', strtotime($option_blood_group->start_date)) }}</span>
                                </div>
                                <div class="meta-right">
                                    <span class="comments"><a ><i class="fa fa-clock-o"></i> {{ $option_blood_group->set_time }}</a></span>
                                </div>
                            </div>
                            <!-- News Text -->
                            <div class="news-text">
                                <p>{!! $option_blood_group->description !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
