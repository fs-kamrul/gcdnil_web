<div class="col-lg-4 col-md-6 mb-4">
    <div class="group-card wow fadeInUp" data-wow-delay="@isset($wow) {{ $wow . 's' }} @endisset">
        <div class="card-image">
            <img src="{{ getImageUrl($admin_club->photo, 'adminboard/adminclub') }}" alt="{{ $admin_club->name }}">
            <div class="card-overlay">
                <a href="{{ $admin_club->url }}" class="btn btn-primary">View Details</a>
            </div>
        </div>
        <div class="card-content">
            <h2><a href="{{ $admin_club->url }}">{{ description_summary($admin_club->name, 40) }}</a></h2>
            <p>{{ description_summary($admin_club->description) }}</p>
        </div>
    </div>
</div>
{{--<div class="col-lg-4 col-md-4 mb-4">--}}
{{--    <div class="group-card wow fadeInUp" data-wow-delay="@isset($wow) {{ $wow . 's' }} @endisset">--}}
{{--        <img src="{{ getImageUrl($admin_club->photo, 'adminboard/adminclub') }}" alt="{{ $admin_club->name }}">--}}
{{--        <h2><a href="{{ $admin_club->url }}">{{ description_summary($admin_club->name, 40) }}</a></h2>--}}
{{--        <p>{{ description_summary($admin_club->short_description) }}</p>--}}
{{--    </div>--}}
{{--</div>--}}


