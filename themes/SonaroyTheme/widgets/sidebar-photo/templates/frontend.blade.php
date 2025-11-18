@php

//dd(get_posts_with_type($config['post_type_id']))
@endphp

@foreach(get_posts_with_type($config['post_type_id']) as $post)
    <div class="column block">
        <h5 class="bk-org title">
            {{ $post->designation }}  	</h5>

        <p style="text-align:center">
            <img alt="{{ $post->name }}"
                 src="{{ getImageUrl($post->photo), 'post' }}" style="height:265px; width:220px"><br>
            <strong>{{ $post->name }}</strong></p>
        <p>
        </p>
    </div>
@endforeach
