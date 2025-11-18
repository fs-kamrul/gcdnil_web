<!-- ----------------------- All venue Start ----------------------- -->
<section id="all_venue" class="mt_100">
    <div class="container">
        <h1 class="section_heading">{{ $shortcode->title }}</h1>
        <div class="all_venue_main mt_80">
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                @foreach($categories as $key=>$value)
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if($key == 0) active @endif" id="venue-{{ $value->slugable->key }}-tab" data-bs-toggle="pill"
                            data-bs-target="#venue-{{ $value->slugable->key }}" type="button" role="tab"
                            aria-controls="venue-{{ $value->slugable->key }}" aria-selected="true">{{ $value->name }}</button>
                </li>
                @endforeach
            </ul>
            <div class="tab-content mt_100" id="pills-tabContent">
                @foreach($categories as $key=>$value)
                <div class="tab-pane fade @if($key == 0) show active @endif" id="venue-{{ $value->slugable->key }}" role="tabpanel"
                     aria-labelledby="vanue-{{ $value->slugable->key }}-tab" tabindex="0">
                    @php
                        $posts = $value->post;
//                        dd($posts);
                    @endphp
{{--                    {{ $value->name }}--}}
                    @include(Theme::getThemeNamespace() . '::views.venue.includes.venue-items', compact('posts'))
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- ----------------------- All Venues End ----------------------- -->

{{--<!-- ----------------------- Reserve thie venue Start ----------------------- -->--}}
{{--<section id="reserve_venue">--}}
{{--    <div class="container">--}}
{{--        <div class="reserve_venue_main">--}}
{{--            <h6 class="section_heading">{{ theme_option('action_venue_title_text') }}</h6>--}}
{{--            <p>{{ theme_option('action_venue_massage_text') }}</p>--}}
{{--            <a href="{{ theme_option('action_venue_contact_us_text') }}" class="green_outline_btn">@lang('Contact Us')</a>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}
{{--<!-- ----------------------- Reserve this venue End ----------------------- -->--}}
