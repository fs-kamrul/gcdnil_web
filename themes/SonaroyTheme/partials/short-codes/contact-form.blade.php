{{--mb_150--}}
<section id="contact" class="">
    <div class="contact_main mt_150">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 py-5">
                    [our-offices][/our-offices]
                </div>

                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 py-5">
                    <div class="contact_form">
                        <h6 class="section_heading">@lang('Write Us A Message')</h6>
                        {!!    Form::open(['route' => 'public.send.contact', 'method' => 'POST', 'class' => 'mt_45']) !!}
                            <div class="form_group">
                                <label for="name">@lang('Name')</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="contact_name"
                                       placeholder="{{ __('Name') }}">
                            </div>

                            <div class="form_group">
                                <label for="email">@lang('Email Address')</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" id="contact_email"
                                       placeholder="{{ __('Your Email Address') }}">
                            </div>

                            <div class="form_group">
                                <label for="contact">@lang('Contact')</label>
                                <input type="number" class="form-control" name="phone" value="{{ old('phone') }}" id="contact_phone"
                                       placeholder="{{ __('Your Contact') }}">
                            </div>
                            <div class="form_group">
                                <label for="contact">@lang('Subject')</label>
                                <input type="text" class="form-control" name="subject" value="{{ old('subject') }}" id="contact_subject"
                                       placeholder="{{ __('Subject') }}">
                            </div>

                            <div class="form_group">
                                <label for="message">@lang('Message')</label>

                                <textarea name="content" class="form-control" id="contact_content" cols="30" rows="10" placeholder="{{ __('Write Here') }}">{{ old('content') }}</textarea>
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
{{--                        <div class="col-12">--}}
{{--                            <p>{!! clean(__('The field with (<span style="color:#FF0000;">*</span>) is required.')) !!}</p>--}}
{{--                        </div>--}}
                            <button class="outline_btn">@lang('Send Message')</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
