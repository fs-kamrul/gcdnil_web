<div class="col-md-6 col-lg-6 wow fadeInUp" data-wow-delay="@isset($wow) {{ $wow . 's' }} @endisset">
    <div class="notice-item" data-department="SB">
        <img src="{{ url( 'themes/' . Theme::getPublicThemeName() . '/img/notice.png') }}" alt="SB">
        <div class="notice-content">
            <h2 class="notice-title"><a href="{{ $admin_club->url }}">{{ description_summary($admin_club->name, 60) }}</a></h2>
            <p class="notice-department">{{ description_summary($admin_club->short_description) }}</p>
            <div class="notice-meta">
                @if($admin_club->categories->count())<span class="notice-type">{{ getCategoryNames($admin_club) }}</span> @endif
                <span class="notice-date">{{ date('d F Y', strtotime($admin_club->created_at)) }}</span>
            </div>
        </div>
    </div>
</div>

