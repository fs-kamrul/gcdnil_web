{{--@if (theme_option('contact_info_boxes'))--}}

{{--        @foreach(json_decode(theme_option('contact_info_boxes'), true) as $key=>$item)--}}
{{--            <div class="contact_person">--}}
{{--                <h1 class="section_heading">{!! DboardHelper::clean($item[0]['value']) !!}</h1>--}}
{{--                <div class="contact_person_info mt_45">--}}
{{--                    <h6 class="font_pop">{!! DboardHelper::clean($item[1]['value']) !!}</h6>--}}
{{--                    <div class="contact_person_details">--}}
{{--                        <p>{!! DboardHelper::clean($item[2]['value']) !!}</p>--}}
{{--                        <p>{!! DboardHelper::clean($item[3]['value']) !!}</p>--}}
{{--                        <p>@lang('Cell'): <a href="tel:{!! DboardHelper::clean($item[4]['value']) !!}">{!! DboardHelper::clean($item[4]['value']) !!}</a></p>--}}
{{--                        <p>@lang('Email'): <a href="mailto:{!! DboardHelper::clean($item[5]['value']) !!}">{!! DboardHelper::clean($item[5]['value']) !!}</a></p>--}}
{{--                        <a target="_blank" class="btn btn-outline btn-sm btn-brand-outline font-weight-bold text-brand bg-white text-hover-white mt-20 border-radius-5 btn-shadow-brand hover-up" href="https://maps.google.com/?q={{ urlencode(clean($item[3]['value'])) }}"><i class="ri-map-2-line text-muted mr-15"></i>{{ __('View map') }}</a>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    <hr>--}}
{{--@endif--}}
@if (theme_option('contact_info_boxes'))
    <div class="contact-info-section">
        <div class="row g-4">
            @foreach(json_decode(theme_option('contact_info_boxes'), true) as $key=>$item)
                <div class="col-xs-6 col-xl-12 mb-4">
                    <div class="contact-person-card h-100 position-relative overflow-hidden">
                        <!-- Gradient Background Overlay -->
                        <div class="card-gradient-overlay"></div>

                        <!-- Main Card Content -->
                        <div class="card border-0 h-100 shadow-lg">
                            <div class="card-body p-0">
                                <!-- Header Section with Gradient -->
                                <div class="contact-header bg-gradient-primary text-white p-4 position-relative">
                                    <div class="contact-avatar mb-3">
                                        <div class="avatar-circle bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="ri-user-3-line text-white h4 mb-0"></i>
                                        </div>
                                    </div>
                                    <h3 class="h5 font-weight-bold mb-1 text-white">
                                        {!! DboardHelper::clean($item[0]['value']) !!}
                                    </h3>
                                    <p class="text-white-50 mb-0 small font-weight-medium">
                                        {!! DboardHelper::clean($item[1]['value']) !!}
                                    </p>
                                </div>

                                <!-- Contact Details Section -->
                                <div class="contact-details p-4">
                                    <!-- Company/Organization -->
                                    <div class="contact-item d-flex align-items-start mb-3">
                                        <div class="contact-icon">
                                            <div class="icon-wrapper bg-light rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="ri-building-4-line text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="contact-text ml-3">
                                            <p class="mb-0 text-dark font-weight-medium">
                                                {!! DboardHelper::clean($item[2]['value']) !!}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Address -->
                                    <div class="contact-item d-flex align-items-start mb-3">
                                        <div class="contact-icon">
                                            <div class="icon-wrapper bg-light rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="ri-map-pin-2-fill text-danger"></i>
                                            </div>
                                        </div>
                                        <div class="contact-text ml-3">
                                            <p class="mb-0 text-muted small">
                                                {!! DboardHelper::clean($item[3]['value']) !!}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Phone -->
                                    <div class="contact-item d-flex align-items-center mb-3">
                                        <div class="contact-icon">
                                            <div class="icon-wrapper bg-light rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="ri-phone-fill text-success"></i>
                                            </div>
                                        </div>
                                        <div class="contact-text ml-3">
                                            <a href="tel:{!! DboardHelper::clean($item[4]['value']) !!}"
                                               class="text-decoration-none text-dark font-weight-medium hover-primary transition-all">
                                                {!! DboardHelper::clean($item[4]['value']) !!}
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="contact-item d-flex align-items-center mb-4">
                                        <div class="contact-icon">
                                            <div class="icon-wrapper bg-light rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="ri-mail-fill text-info"></i>
                                            </div>
                                        </div>
                                        <div class="contact-text ml-3">
                                            <a href="mailto:{!! DboardHelper::clean($item[5]['value']) !!}"
                                               class="text-decoration-none text-primary font-weight-medium hover-underline">
                                                {!! DboardHelper::clean($item[5]['value']) !!}
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="contact-actions">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <a target="_blank"
                                                   class="btn btn-primary btn-block rounded-pill font-weight-bold shadow-sm hover-shadow-lg transition-all"
                                                   href="https://maps.google.com/?q={{ urlencode(clean($item[3]['value'])) }}">
                                                    <i class="ri-map-2-line mr-2"></i>
                                                    {{ __('View on Map') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Action Buttons -->
                        <div class="floating-actions position-absolute">
                            <a href="tel:{!! DboardHelper::clean($item[4]['value']) !!}"
                               class="btn btn-success btn-sm rounded-circle shadow-lg fab-call">
                                <i class="ri-phone-fill"></i>
                            </a>
                            <a href="mailto:{!! DboardHelper::clean($item[5]['value']) !!}"
                               class="btn btn-info btn-sm rounded-circle shadow-lg fab-email mt-2">
                                <i class="ri-mail-fill"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{-- <hr class="my-5 border-light"> --}}
@endif
