<div class="col-md-4 col-lg-3 mb-5 wow fadeInUp" data-wow-delay="@isset($wow) {{ $wow . 's' }} @endisset">
    <div class="card-wrapper">
        <div class="card" style="height: 500px;">
            <img src="{{ getImageUrl($event->photo, 'adminboard/adminnews') }}" class="card-img-top" alt="{{ $event->name }}">
            <div class="card-body">
                <h5 class="card-title">{{ description_summary($event->name, 40) }}</h5>
                <samp><i class="fa fa-calendar"></i> {{ date('F d, Y', strtotime($event->start_date)) }}</samp><br/>
                <samp><i class="fa fa-clock-o"></i> {{ $event->set_time }}</samp><br/>
                <p class="card-text">
                    {{ description_summary($event->description) }}
                </p>
                <a href="{{ $event->url }}" class="btn btn-primary mt-2">@lang('adminboard::lang.read_more')</a>
            </div>
        </div>
    </div>
</div>
