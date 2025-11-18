<div>
    @if ($branch->count() > 0)
            <article>
                <div>
                    <header>
                        <div>
{{--                            <span>{{ $post->created_at->format('M d, Y') }}</span>--}}
                            <span>{{ $branch->user->name }}</span> - <a href="{{ $branch->slug }}">{{ $branch->name }}</a></div>
                    </header>
                    <div>
                        <p>{{ $branch->description }}</p>
                    </div>
                </div>
            </article>
        <div>
        </div>
    @else
        <div>
            <p>{{ __('There is no data to display!') }}</p>
        </div>
    @endif
</div>
