<div class="col-lg-6 col-md-6 mb-4">
    <div class="group-card wow fadeInUp" data-wow-delay="@isset($wow) {{ $wow . 's' }} @endisset">
        <img src="{{ getImageUrl($academic_group->photo, 'adminboard/adminacademicgroup') }}" alt="{{ $academic_group->name }}">
        <h2><a href="{{ $academic_group->url }}">{{ $academic_group->name }}</a></h2>
        <p>{{ description_summary($academic_group->short_description) }}</p>
    </div>
</div>
