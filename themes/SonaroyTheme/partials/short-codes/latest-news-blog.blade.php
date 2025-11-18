<div class="columns block mb-3" id="notice-board">
    <div class="notice-board-bg">
        <h2>{{ $shortcode->title }}</h2>
        <div id="notice-board-ticker">
            <ul>
                @foreach($notice_boards as $key=>$notice_board)
                    <li><a href="{{ $notice_board->url }}">{{ description_summary($notice_board->name, 200) }}</a></li>
                @endforeach
{{--                @if($events->count())--}}
{{--                    @foreach($events as $data)--}}
{{--                    <li><a href="{{ $data->url }}">{{ description_summary($data->name, 200) }}</a></li>--}}
{{--                    @endforeach--}}
{{--                @endif--}}
{{--                @if($news->count())--}}
{{--                    @foreach($news as $data)--}}
{{--                        <li><a href="{{ $data->url }}">{{ description_summary($data->name, 200) }}</a></li>--}}
{{--                    @endforeach--}}
{{--                @endif--}}
            </ul>
{{--            @if($shortcode->button_url1)--}}
                <a class="btn right" href="{{ url('notice-board') }}">@lang('adminboard::lang.all')</a>
{{--            @endif--}}
        </div>
    </div>
</div>
