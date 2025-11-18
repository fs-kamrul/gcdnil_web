

<!-- --------------------- Contact page Start --------------------- -->
<section id="contact_page">
    <div class="container">
        <div class="contact_main">
            <div class="row">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="img_long_left">
                        @php
//                        dd($title);
                            if(isset($image)){
                                $get_image = getImageUrlById($image,'shortcodes');
//                                $path_post = 'uploads/shortcodes/';
//                                $photo = $path_post . $get_image->name;
                            }else{
                                $photo = '';
                            }
                        @endphp
                        <img src="{{$get_image }}" alt="{{ $title }}">
                    </div>
                </div>

                <div class="offset-xxl-1 col-xxl-5 offset-xl-1 col-xl-5 offset-lg-1 col-lg-5 col-md-12 col-sm-12">
                    <div class="info_right">
                        <h1 class="heading_40 primary_text">{{ $title }}</h1>

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
