<div class="single-notice">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="notice-details text-justify">
                    <h2 class="Notice-title"><i class="{{ $facility->icon }}"></i> {{ $facility->name }}</h2>
{{--                    <span class="publish-info">@lang('adminboard::lang.published_date') : {{ date('d F Y', strtotime($facility->created_at)) }}</span>--}}
                    <p class="notice-description">{!! $facility->description !!}</p>
                    @if($facility->photo != null)
                        <img src="{{ getImageUrl($facility->photo,'adminboard/adminacademicgroup') }}" alt="{{ $facility->name }}">
                        <br/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
