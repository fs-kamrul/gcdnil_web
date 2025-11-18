<div class="column  bg-light p-3 border rounded" style="width: 100%;">
{{--    <h5 class="bk-org title internal-eservice">--}}
{{--        <a>{{ $config['name'] }}</a>--}}
{{--    </h5>--}}
    <!-- Logo -->
    <div class="text-center mb-4">
        <img src="{{ getImageUrlById(theme_option('logo'), 'shortcodes') }}"
             alt="{{ theme_option('site_title') }}"
             class="img-fluid" style="max-height: 60px;">
    </div>

    <!-- Contact Info -->
    @if (theme_option('address') || theme_option('site_phone') || theme_option('site_email'))
        <div class="mb-4">
            <ul class="list-unstyled text-muted small">
                @if (theme_option('address'))
                    <li class="mb-2">
                        <i class="ri-map-pin-fill"></i>
                        <a href="{{ theme_option('address_google') }}" target="_blank" class="text-muted">
                            {{ theme_option('address') }}
                        </a>
                    </li>
                @endif
                @if (theme_option('site_phone'))
                    <li class="mb-2">
                        <i class="ri-phone-fill"></i>
                        <a href="tel:{{ theme_option('site_phone') }}" class="text-muted">
                            {{ theme_option('site_phone') }}
                        </a>
                    </li>
                @endif
                @if (theme_option('site_email'))
                    <li class="mb-2">
                        <i class="ri-mail-fill"></i>
                        <a href="mailto:{{ theme_option('site_email') }}" class="text-muted">
                            {{ theme_option('site_email') }}
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    @endif

    <!-- Social Links -->
    <div>
        <ul class="list-inline">
            @for ($i = 1; $i <= 5; $i++)
                @if (theme_option('social_' . $i . '_url') && theme_option('social_' . $i . '_name'))
                    <li class="list-inline-item mb-2">
                        <a href="{{ theme_option('social_' . $i . '_url') }}" target="_blank"
                           class="btn btn-sm text-white"
                           style="background-color: {{ theme_option('social_' . $i . '_color') }}"
                           title="{{ theme_option('social_' . $i . '_name') }}">
                            <i class="{{ theme_option('social_' . $i . '_icon') }}"></i>
                        </a>
                    </li>
                @endif
            @endfor
        </ul>
    </div>
</div>
