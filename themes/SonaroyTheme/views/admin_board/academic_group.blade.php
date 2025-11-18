<div class="single-notice">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="notice-details">
                    <h2 class="Notice-title">{{ $academic_group->name }}</h2>
                    <span class="publish-info">@lang('adminboard::lang.published_date') : {{ date('d F Y', strtotime($academic_group->created_at)) }}</span>
                    <p class="notice-description">{!! clean($academic_group->description) !!}</p>
                    @if($academic_group->photo != null)
                        <img src="{{ getImageUrl($academic_group->photo,'adminboard/adminacademicgroup') }}" alt="{{ $academic_group->name }}">
                        <br/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
