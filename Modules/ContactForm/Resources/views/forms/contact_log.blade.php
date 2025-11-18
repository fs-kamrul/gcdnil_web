<!-- Quote Start -->
<div class="container-xxl py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-secondary text-uppercase mb-3">@lang('Get A Quote')</h6>
                <h1 class="mb-5">{{ $shortcode->title }}</h1>
                <p class="mb-5">{!! $shortcode->description !!}</p>
                <div class="d-flex align-items-center">
                    <i class="fa fa-headphones fa-2x flex-shrink-0 bg-primary p-3 text-white"></i>
                    <div class="ps-4">
                        <h6>@lang('Call for any query!')</h6>
                        <h3 class="text-primary m-0">{{ theme_option('site_phone') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="bg-light text-center p-5 wow fadeIn" data-wow-delay="0.5s">

                    {!!    Form::open(['route' => 'public.send.contact', 'method' => 'POST', 'class' => 'contact-form']) !!}
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <input type="text" class="form-control border-0" name="name" value="{{ old('name') }}" id="contact_name"
                                           placeholder="{{ __('Name') }}">
                        </div>
                        <div class="col-12 col-sm-6">
                            <input type="email" class="form-control border-0" name="email" value="{{ old('email') }}" id="contact_email"
                                   placeholder="{{ __('Email') }}">
                        </div>
                        <div class="col-12 col-sm-6">
                            <input type="text" class="form-control border-0" name="address" value="{{ old('address') }}" id="contact_address"
                                   placeholder="{{ __('Address') }}">
                        </div>
                        <div class="col-12 col-sm-6">
                            <input type="text" class="form-control border-0" name="phone" value="{{ old('phone') }}" id="contact_phone"
                                   placeholder="{{ __('Phone') }}">
                        </div>
                        <div class="col-12 col-sm-6">
                            <input type="text" class="form-control border-0" name="subject" value="{{ old('subject') }}" id="contact_subject"
                                   placeholder="{{ __('Subject') }}">
                        </div>
                        <div class="col-12">
                            <textarea name="content" id="contact_content" class="form-control border-0" rows="5" placeholder="{{ __('Message') }}">{{ old('content') }}</textarea>
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
                        <div class="col-12">
                            <p>{!! clean(__('The field with (<span style="color:#FF0000;">*</span>) is required.')) !!}</p>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100 py-3">{{ __('Send') }}</button>
                        </div>
                    </div>

                        <div class="contact-form-group">
                            <div class="contact-message contact-success-message" style="display: none"></div>
                            <div class="contact-message contact-error-message" style="display: none"></div>
                        </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Quote End -->
