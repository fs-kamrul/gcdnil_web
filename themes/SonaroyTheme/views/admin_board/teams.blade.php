<div class="sixteen columns mb_100" id="contents">
    <div class="container">
        <div class="row justify-content-center">
            @foreach($teams as $key => $team)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 text-center border-0 shadow-sm">
                        <img src="{{ getImageUrl($team->photo, 'adminboard/adminteam') }}"
                             class="card-img-top img-fluid"
                             alt="{{ $team->name }}"
                             style="object-fit: cover; height: 250px;">
                        <div class="card-body">
                            <h5 class="card-title mb-1">
                                <a href="{{ $team->url }}" class="text-decoration-none text-dark">
                                    {{ $team->name }}
                                </a>
                            </h5>
                            <p class="text-muted mb-3">{{ $team->designation }}</p>
                            <div class="d-flex justify-content-center gap-3">
                                @if($team->facebook_id)
                                    <a href="{{ $team->facebook_id }}" target="_blank" class="text-secondary">
                                        <i class="fa fa-facebook-f"></i>
                                    </a>
                                @endif
                                @if($team->email)
                                    <a href="mailto:{{ $team->email }}" class="text-secondary">
                                        <i class="fa fa-envelope-o"></i>
                                    </a>
                                @endif
                                @if($team->google_site)
                                    <a href="{{ $team->google_site }}" target="_blank" class="text-secondary">
                                        <i class="fa fa-google"></i>
                                    </a>
                                @endif
                                @if($team->linkedin_id)
                                    <a href="{{ $team->linkedin_id }}" target="_blank" class="text-secondary">
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($teams->total() > 0)
            <div class="d-flex justify-content-center mt-4">
                {!! $teams->links(Theme::getThemeNamespace() . '::partials.admin_board.pagination') !!}
            </div>
        @endif
    </div>
</div>
