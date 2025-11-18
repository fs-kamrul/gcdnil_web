@if ($posts->count() > 0)
    @foreach ($posts as $post)
        <article>
            <div>
                @php
                    $path_post = 'uploads/post/';
                    if($post->photo == ''){
                            $photo = 'vendor/kamruldashboard/images/image-not-found.jpg';
                        }else{
                            $photo = $path_post . $post->photo;
                        }
                @endphp
                <a href="{{ $post->url }}">
                    <img src="{{$photo}}" alt="{{ $post->name }}">
                </a>
            </div>
            <div>
                <header>
                    <h3><a href="{{ $post->url }}">{{ $post->name }}</a></h3>
                    <div><span>{{ $post->created_at->format('M d, Y') }}</span>
                        <span>{{ $post->user->name }}</span> -
                        {{ __('Categories') }}:
                        @foreach($post->categories as $category)
                            <a href="{{ $category->url }}">{{ $category->name }}</a>
                            @if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </div>
                </header>
                <div>
                    <p>{{ $post->description }}</p>
                </div>
            </div>
        </article>
    @endforeach
    <div>
        {!! $posts->withQueryString()->links() !!}
    </div>
@endif
