<style>
    .details {
        text-align: left !important;
    }
    .at-a-glance h2 {
        text-align: left !important;
    }
    .h_text{
        line-height: 18px;
    }
</style>
<div class="col-md-4 col-lg-3 wow fadeInUp" data-wow-delay="@isset($wow) {{ $wow . 's' }} @endisset">
    <div class="gov-p">
        <div class="card-wrapper">
            <div class="card">
                <div class="card-image">
                    <img src="{{ getImageUrl($team->photo, 'adminboard/adminteam') }}" alt="{{ $team->name }}">
                </div>
                <ul class="social-icons">
                    @if($team->facebook_id)<li><a target="_blank" href="{{ $team->facebook_id }}"><i class="fa fa-facebook-f"></i></a></li>@endif
                    @if($team->email)<li><a href="mailto:{{ $team->email }}"><i class="fa fa-envelope-o"></i></a></li>@endif
                    @if($team->google_site)<li><a target="_blank" href="{{ $team->google_site }}"><i class="fa fa-google"></i></a></li>@endif
                    @if($team->linkedin_id)<li><a target="_blank" href="{{ $team->linkedin_id }}"><i class="fa fa-linkedin"></i></a></li>@endif
                </ul>
            </div>
            <div class="details mt-3">
                <h2 class="h_text"><a href="{{ $team->url }}">{{ $team->name }}</a></h2>
                <p>{{ $team->designation }}</p>
            </div>
        </div>
    </div>
</div>
