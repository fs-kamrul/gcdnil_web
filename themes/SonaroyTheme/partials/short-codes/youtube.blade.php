@if (!empty($url))
    <div class="columns block mt-3">
        <h5 class="bk-org title">{{ $shortcode->title }}</h5>
        <iframe  frameborder="0" height="400"  width="100%" src="{{ $url }}" frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                 title="{{ Arr::get($shortcode, 'title') }}"
                allowfullscreen></iframe>
    </div>
@endif
