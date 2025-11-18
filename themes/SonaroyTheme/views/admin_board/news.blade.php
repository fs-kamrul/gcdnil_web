<div class="row columns mb_100">
    <div class="container my-5 columns mb_100">
        <div class="card shadow-sm">
            <div class="card-body">
                <!-- Notice Title -->
                <h3 class="card-title text-primary mb-3">
                    {{ $News->name }}
                </h3>

                <!-- Published Date -->
                <p class="text-muted mb-4">
                    <strong>@lang('adminboard::lang.published_date'):</strong>
                    {{ date('d F Y', strtotime($News->created_at)) }}
                </p>

                <!-- Description -->
                <div class="mb-4">
                    {!! clean($News->description) !!}
                </div>

                <div class="mb-4">
                    <!-- Social Share -->
                    <ul class="social-share">
                        <li class="facebook"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}&title={{ strip_tags(SeoHelper::getDescription()) }}"><i class="fa fa-facebook"></i><span>Facebook</span></a></li>
                        <li class="twitter"><a target="_blank" href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ strip_tags(SeoHelper::getDescription()) }}"><i class="fa fa-twitter"></i><span>Twitter</span></a></li>
                        {{--                                    <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>--}}
                        <li class="linkedin"><a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&summary={{ rawurldecode(strip_tags(SeoHelper::getDescription())) }}"><i class="fa fa-linkedin"></i></a></li>
                        {{--                                    <li class="pinterest"><a href="#"><i class="fa fa-pinterest"></i></a></li>--}}
                    </ul>
                </div>
                <!-- Photo Display -->
                @if($News->photo != null)
                    <div class="mb-4 text-center">
                        <img src="{{ getImageUrl($News->photo,'adminboard/adminnews') }}"
                             class="img-fluid rounded border"
                             alt="{{ $News->name }}">
                    </div>
                @endif

                <!-- Document Download -->
                @if($News->document != null)
                    <div class="text-center">
                        <a href="{{ getImageUrl($News->document,'adminboard/adminnews') }}"
                           class="btn btn-outline-primary"
                           target="_blank">
                            @lang('adminboard::lang.download_notice')
                        </a>
                    </div>
                @endif
            </div>

            {{--                {!! Theme::partial('adminboard_recent', ['posts' => $Newses, 'photo' => 'adminboard/adminnews']) !!}--}}
        </div>
    </div>
</div>
