@foreach ($posts as $post)
    <div>
        <article>
            <div><a href="{{ $post->url }}"></a>
                <img src="{{ getImageUrl($post->image) }}" alt="{{ $post->name }}">
            </div>
            <header><a href="{{ $post->url }}"> {{ $post->name }}</a></header>
        </article>
    </div>
@endforeach

<div class="pagination">
    {!! $posts->withQueryString()->links() !!}
</div>
