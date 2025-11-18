<div class="col-md-6 col-lg-6 wow fadeInUp" data-wow-delay="@isset($wow) {{ $wow . 's' }} @endisset">
    <div class="notice-item" data-department="SB">
        <img src="{{ url( 'themes/' . Theme::getPublicThemeName() . '/img/notice.png') }}" alt="SB">
        <div class="notice-content">
            <h2 class="notice-title"><a href="{{ $option_blood_group->url }}">{{ description_summary($option_blood_group->name, 60) }}</a></h2>
            <p class="notice-department">{{ description_summary($option_blood_group->short_description) }}</p>
            <div class="notice-meta">
                @if($option_blood_group->categories->count())<span class="notice-type">{{ getCategoryNames($option_blood_group) }}</span> @endif
                <span class="notice-date">{{ date('d F Y', strtotime($option_blood_group->created_at)) }}</span>
            </div>
        </div>
    </div>
</div>

