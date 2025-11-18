<section id="{{ $shortcode->section_type }}">
    <div class="{{ $shortcode->section_type }}_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12">
                    <div class="@if($shortcode->section_type == 'why_dsc') dsc_text @else video_text @endif">
                        <h2 class="section_heading">{{ $shortcode->title }}</h2>
                        <p class="mt_40">{{ $shortcode->contain }}</p>
                        @if($shortcode->button_label)
                            <a href="{{ $shortcode->button_url }}" class="outline_btn mt_55">{{ $shortcode->button_label }}</a>
                        @endif

                        @if($shortcode->section_type == 'why_dsc')
                            <div class="why_dsc_data">
                                <div class="data_box">
                                    <div class="data_img">
                                        <img src="{{ asset('themes/'. Theme::getThemeName() .'/images/icons/building.png') }}" alt="building">
                                    </div>

                                    <div class="data_info">
                                        <p class="section_heading">{{ theme_option('action_space_text') }}</p>
                                        <p class="font_pop font_22">@lang('Space')</p>
                                    </div>
                                </div>

                                <div class="data_box">
                                    <div class="data_img">
                                        <img src="{{ asset('themes/'. Theme::getThemeName() .'/images/icons/food.png') }}" alt="food">
                                    </div>

                                    <div class="data_info">
                                        <p class="section_heading">{{ theme_option('action_menu_text') }}</p>
                                        <p class="font_pop font_22">@lang('Menu')</p>
                                    </div>
                                </div>

                                <div class="data_box">
                                    <div class="data_img">
                                        <img src="{{ asset('themes/'. Theme::getThemeName() .'/images/icons/seats.png') }}" alt="seats">
                                    </div>

                                    <div class="data_info">
                                        <p class="section_heading">{{ theme_option('action_seats_text') }}</p>
                                        <p class="font_pop font_22">@lang('Seats')</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="offset-xxl-1 col-xxl-6 offset-xl-1 col-xl-6 offset-lg-1 col-lg-6 col-md-12 col-sm-12">
                    <div class="@if($shortcode->section_type == 'video_view') video_main_img @else dsc_main_img @endif">
                        <img src="{{ getImageUrlById($shortcode->image, 'shortcodes') }}" alt="{{ $shortcode->title }}">
                        @if($shortcode->section_type == 'video_view')
                            <a class="play_icon" href="{{ $shortcode->video_url }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="91.5" height="91.5"
                                     viewBox="0 0 91.5 91.5">
                                    <g id="Group_168" data-name="Group 168" transform="translate(-1252.25 -5037.5)">
                                        <g id="Ellipse_5" data-name="Ellipse 5" transform="translate(1254 5039)"
                                           fill="#022048" stroke="#707070" stroke-width="1" opacity="0.58">
                                            <circle cx="44.5" cy="44.5" r="44.5" stroke="none" />
                                            <circle cx="44.5" cy="44.5" r="44" fill="none" />
                                        </g>
                                        <g id="Video" transform="translate(1253.75 5039)">
                                            <path id="Path_13" data-name="Path 13"
                                                  d="M91.5,47.25A44.25,44.25,0,1,1,47.25,3,44.25,44.25,0,0,1,91.5,47.25Z"
                                                  transform="translate(-3 -3)" fill="none" stroke="#fff"
                                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
                                            <path id="Path_14" data-name="Path 14" d="M15,12,41.55,29.7,15,47.4Z"
                                                  transform="translate(20.4 14.55)" fill="none" stroke="#fff"
                                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        @endif
                        <div class="dsc_bg_img">
                            <div class="overlay"></div>
                            <img src="{{ getImageUrlById($shortcode->image, 'shortcodes') }}" alt="{{ $shortcode->title }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
