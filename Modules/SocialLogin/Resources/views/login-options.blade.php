@if (SocialService::hasAnyProviderEnable())
    <div class="sign_group">
        <p>@lang('or Sign in with')</p>
        <div class="sign_icon_group">
            @foreach (SocialService::getProviderKeys() as $item)
                @if (SocialService::getProviderEnabled($item))
                    <a class="social-icon-color sign_icon {{ $item }}" data-bs-toggle="tooltip" data-bs-original-title="{{ $item }}"
                           href="{{ route('auth.social', isset($params) ? array_merge([$item], $params) : $item) }}">
                        <i class="{{ setting('social_login_'.$item.'_app_icon') }}"></i>
                    </a>
                @endif
            @endforeach
{{--            <a href="#" class="sign_icon">--}}
{{--                <i class="fa-brands fa-google"></i>--}}
{{--            </a>--}}
{{--            <a href="#" class="sign_icon">--}}
{{--                <i class="fa-brands fa-facebook-f"></i>--}}
{{--            </a>--}}
{{--            <a href="#" class="sign_icon">--}}
{{--                <i class="fa-brands fa-twitter"></i>--}}
{{--            </a>--}}
        </div>
    </div>
@endif
