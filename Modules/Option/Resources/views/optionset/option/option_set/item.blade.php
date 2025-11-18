<div class="col-md-6 col-lg-6 wow fadeInUp" data-wow-delay="@isset($wow) {{ $wow . 's' }} @endisset">
    <div class="notice-item" data-department="SB">
        <img src="{{ url( 'themes/' . Theme::getPublicThemeName() . '/img/notice.png') }}" alt="SB">
        <div class="notice-content">
            <h2 class="notice-title"><a href="{{ $option_set->url }}">{{ description_summary($option_set->name, 60) }}</a></h2>
            <p class="notice-department">{{ description_summary($option_set->short_description) }}</p>
            <div class="notice-meta">
                @if($option_set->categories->count())<span class="notice-type">{{ getCategoryNames($option_set) }}</span> @endif
                <span class="notice-date">{{ date('d F Y', strtotime($option_set->created_at)) }}</span>
            </div>
        </div>
    </div>
</div>

