<div class="columns block mb-3" id="notice-board">
    <div class="notice-board-bg">
        <h2>{{ $shortcode->title }}</h2>
        <div id="notice-board-ticker">
            <ul>
                @foreach($post_types->post as $key=>$post)
                <li><a href="{{ $post->url }}">{{ description_summary($post->name, 200) }}</a></li>
                @endforeach
            </ul>
            @if($shortcode->button_url1)
                <a class="btn right" href="{{ $shortcode->button_url1 }}">{{ $shortcode->button_label1 }}</a>
            @endif
        </div>
    </div>
</div>
