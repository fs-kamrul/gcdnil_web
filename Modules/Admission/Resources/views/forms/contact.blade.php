
<!-- --------------------- Contact page Start --------------------- -->
<section id="contact_page">
    <div class="container">
        <div class="contact_main">
            <div class="row">
                <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12">
                    <div class="info_left">
                        <h1 class="heading_40 primary_text">{{ $shortcode->title }}</h1>

                        {!!    Form::open(['route' => 'public.send.contact', 'method' => 'POST', 'class' => 'contact_form mt_40']) !!}
                            <div class="form_group">
{{--                                <label class="primary_text">{{ __('Name') }}</label>--}}
                                <input type="text" value="{{ old('name') }}" id="contact_name" name="name" placeholder="{{ __('Name') }}">
                            </div>

                            <div class="form_group">
{{--                                <label class="primary_text">Email</label>--}}
                                <input type="email" name="email" value="{{ old('email') }}" id="contact_email"
                                       placeholder="{{ __('Your Email') }}">
                            </div>

                            <div class="form_group">
{{--                                <label class="primary_text">{{ __('Contact') }}</label>--}}
                                <input type="number" name="phone" value="{{ old('phone') }}" id="contact_phone"
                                       placeholder="{{ __('Phone Number') }}">
                            </div>

                            <div class="form_group">
{{--                                <label class="primary_text">{{ __('Organization') }}</label>--}}
                                <input type="text" name="organization" id="organization" value="{{ old('organization') }}" placeholder="{{ __('Your Organization') }}">
                            </div>

                            <div class="form_group">
{{--                                <label class="primary_text">Date & time</label>--}}
                                <div class="datetimepicker">
                                    <input type="date" name="contact_data" id="contact_data" value="2018-07-03">
                                    <span></span>
                                    <input type="time" name="contact_time" id="contact_time" value="08:00">
                                </div>
                            </div>

                            <div class="form_group">
{{--                                <label class="primary_text">@lang('Purpose')</label>--}}
                                <textarea name="content" id="contact_content"  cols="30" rows="5" placeholder="{{ __('Your Purpose') }}">{{ old('content') }}</textarea>
                            </div>

                        @if (setting('enable_captcha') && is_module_active('Captcha'))
                            <div class="contact-form-row">
                                <div class="contact-column-12">
                                    <div class="contact-form-group">
                                        {!! Captcha::display() !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                            <button type="submit" class="btn_orange_bold">@lang('Send Message')</button>
                        {!! Form::close() !!}
                    </div>
                </div>

                <div class="offset-xxl-2 col-xxl-5 offset-xl-2 col-xl-5 offset-lg-2 col-lg-5 col-md-12 col-sm-12">
                    <div class="info_right">
                        <h1 class="heading_40 primary_text"></h1>

                        <div class="contact_wrapper mt_20">

                            @if (theme_option('address'))
                                <div class="contact_box mt_40">
                                    <div class="contact_top">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <p class="primary_text">@lang('Address')</p>
                                    </div>
                                    <div class="contact_info">
                                        <p class="primary_text mt_20">{{ theme_option('address') }}</p>
                                    </div>
                                </div>
                            @endif
                            @if (theme_option('site_phone'))
                                <div class="contact_box mt_40">
                                    <div class="contact_top">
                                        <i class="fa-solid fa-phone"></i>
                                        <p class="primary_text">@lang('Contact')</p>
                                    </div>

                                    <div class="contact_info">
                                        <p class="contact_info primary_text mt_20"><a
                                                href="tel:{{ theme_option('site_phone') }}">{{ theme_option('site_phone') }}</a>, <br/><a
                                                href="tel:+{{ theme_option('site_phone2') }}">{{ theme_option('site_phone2') }}</a></p>
                                    </div>
                                </div>
                            @endif
                            @if (theme_option('site_email'))
                                <div class="contact_box mt_40">
                                    <div class="contact_top">
                                        <i class="fa-solid fa-envelope"></i>
                                        <p class="primary_text">@lang('Email')</p>
                                    </div>

                                    <div class="contact_info">
                                        <p class="contact_info primary_text mt_20">
                                            <a href="mailto:{{ theme_option('site_email') }}">{{ theme_option('site_email') }}</a>,
                                            <a href="mailto:{{ theme_option('site_email2') }}">{{ theme_option('site_email2') }}</a>
                                        </p>
                                    </div>
                                </div>
                            @endif

                            {{--                            <div class="contact_box mt_40">--}}
                            {{--                                <div class="contact_top">--}}
                            {{--                                    <i class="fa-brands fa-facebook-f"></i>--}}
                            {{--                                    <p class="primary_text">Facebook</p>--}}
                            {{--                                </div>--}}

                            {{--                                <div class="contact_info">--}}
                            {{--                                    <p class="contact_info primary_text mt_20">--}}
                            {{--                                        <a href="hrdioffice@hrdi.ac"--}}
                            {{--                                           target="_blank">https://www.facebook.com/HRDI.DIU/</a>--}}
                            {{--                                    </p>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- --------------------- Certificate Verification End --------------------- -->

