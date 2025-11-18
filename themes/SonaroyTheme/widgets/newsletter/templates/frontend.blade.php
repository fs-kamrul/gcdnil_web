@if (is_module_active('Newsletter'))

    @php
    Assets::addScriptsDirectly(Theme::asset()->url('js/newsletter.js'));
    @endphp
    <div class="col-lg-3 col-md-6">
        <form class="form-inline" action="#" method="POST">
            @csrf
        <h4 class="text-light mb-4">{{ $config['name'] }}</h4>
        <p>@lang('Dolor amet sit justo amet elitr clita ipsum elitr est.')</p>
        <div class="position-relative mx-auto" style="max-width: 400px;">
            <input class="form-control border-0 w-100 py-3 ps-4 pe-5 email_input" id="email" name="email" type="email" placeholder="{{ __('Enter your email') }}">
            @if (setting('enable_captcha') && is_module_active('Captcha'))
                {!! Captcha::display() !!}
            @endif
            <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2 newsletter_submit_btn"  data-url="{{ route('public.newsletter.subscribe') }}">{{ __('SignUp') }}</button>
        </div>

        </form>
    </div>

@endif
