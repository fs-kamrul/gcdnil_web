<!-- --------------- Newsletter Section Start --------------- -->
{{--<div class="section mb-0">--}}
{{--    <div class="container clearfix">--}}

{{--        <div class="heading-block center">--}}
{{--            <h3>@lang('newsletter::lang.subscribe_to_our_newsletter')</h3>--}}
{{--        </div>--}}

{{--        <div class="subscribe-widget">--}}
{{--            <div class="widget-subscribe-form-result"></div>--}}
{{--            <form id="widget-subscribe-form2" action="#" method="post" class="mb-0">--}}
{{--                <div class="input-group input-group-lg mx-auto" style="max-width:600px;">--}}
{{--                    <div class="input-group-text"><i class="icon-email2"></i></div>--}}
{{--                    <input type="email" name="email" id="email" class="form-control required email" placeholder="@lang('newsletter::lang.enter_your_email')">--}}
{{--                    <button class="btn btn-secondary newsletter_submit_btn" type="submit"  data-url="{{ route('public.newsletter.subscribe') }}">@lang('newsletter::lang.subscribe_now') @endlang</button>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}

{{--    </div>--}}
{{--</div>--}}
{{--<section id="newsletter">--}}
{{--    <div class="container newsletter">--}}
{{--        <div class="newsletter_main" data-aos="fade-in" data-aos-delay="200">--}}
{{--            <h3>@lang('newsletter::lang.subscribe_to_our_newsletter')</h3>--}}
{{--            <form action="#" method="POST">--}}
{{--                @csrf--}}
{{--                <div class="input_wrap">--}}
{{--                    <input type="email" name="email" id="email" placeholder="@lang('newsletter::lang.email_address')">--}}
{{--                    <button type="submit" class="newsletter_submit_btn" data-url="{{ route('public.newsletter.subscribe') }}">--}}
{{--                        <i class="fa-solid fa-circle-chevron-right"></i>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}
<!-- --------------- Newsletter Section End --------------- -->

<!-- --------------------- Subscribe Start --------------------- -->
<style>
    .toast-bottom-right {
        bottom: 75px;
    }
</style>
<script>
    var csrf_token = "{{ csrf_token() }}";
</script>
<section id="subscribe">
    <div class="container">
        <div class="subscribe_main center_text">
            <h5 class="heading_40 white_text">@lang('newsletter::lang.get_updates_on_latest_learning_resources')</h5>
            <p class="white_text mt_40">@lang('newsletter::lang.description_test')</p>
            <div class="subscribe_wrapper">
                <form action="{{ route('public.newsletter.subscribe') }}" method="POST">
                    @csrf
                    <input type="email" name="email" class="email_input" id="email" placeholder="@lang('newsletter::lang.email_address')">
                    @if (setting('enable_captcha') && is_module_active('Captcha'))
                        {!! Captcha::display() !!}
                    @endif
                    <button type="submit" class="newsletter_submit_btn" data-url="{{ route('public.newsletter.subscribe') }}">@lang('newsletter::lang.subscribe')</button>
                    <div class="form_group mt_30">
                        <input type="checkbox" id="newsletter_agree" name="newsletter_agree" value="">
                        <label for="newsletter_agree"> @lang('I agree to the') <a href="{{ url('terms-and-condition') }}" target="_blank">@lang('Users Terms')</a> & <a href="{{ url('privacy-policy') }}" target="_blank">@lang('Privacy Policy')</a></label>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- --------------------- Subscribe End --------------------- -->
