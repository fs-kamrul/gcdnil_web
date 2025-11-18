<div class="hero_slider">
    @php
        $data_photo= $shortcode->pics_file;
        $data_photo = explode(',', $data_photo);
    @endphp
    @foreach($data_photo as $image)
        <div class="hero_box">
            <div class="overlay"></div>
            <img src="{{ getImageUrlById($image, 'shortcodes') }}" alt="Image">
        </div>
    @endforeach
</div>

<div class="hero_details">
    <div class="container">
        <h6 class="font_pop font_500 green_text text_upper">{{ $shortcode->title }}</h6>
        <h1 class="font_old font_700 white_text">{{ $shortcode->contain }}</h1>
        <h2 class="font_old font_700 white_text">{{ $shortcode->contain2 }}</h2>
        <p class="font_pop font_300 white_text">{{ $shortcode->tag_line }}</p>

        @if($shortcode->button_label1)
            <a class="green_btn" href="{{ $shortcode->button_url1 }}">{{ $shortcode->button_label1 }}</a>
        @endif
    </div>
</div>

<div class="down_arrow">
    <a href="#why_dsc">
        <svg xmlns="http://www.w3.org/2000/svg" width="48.393" height="48.393" viewBox="0 0 48.393 48.393">
            <g id="Icon_feather-arrow-down-circle" data-name="Icon feather-arrow-down-circle"
               transform="translate(-2 -2)" opacity="0.75">
                <path id="Path_5" data-name="Path 5"
                      d="M49.393,26.2A23.2,23.2,0,1,1,26.2,3,23.2,23.2,0,0,1,49.393,26.2Z"
                      transform="translate(0 0)" fill="none" stroke="#f0f7ee" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2" />
                <path id="Path_6" data-name="Path 6" d="M12,18l9.279,9.279L30.557,18"
                      transform="translate(4.918 8.197)" fill="none" stroke="#f0f7ee" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="2" />
                <path id="Path_7" data-name="Path 7" d="M18,12V30.557" transform="translate(8.197 4.918)"
                      fill="none" stroke="#f0f7ee" stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" />
            </g>
        </svg>
    </a>
</div>
