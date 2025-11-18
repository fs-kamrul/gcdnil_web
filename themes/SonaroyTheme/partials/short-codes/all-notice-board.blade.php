
<div class="row columns mb_100">
    <table class="table table-striped noticeboard_table">
        <thead>
        <tr>
            <th scope="col">@lang('SL')</th>
            <th scope="col">@lang('Title')</th>
            <th scope="col">@lang('Publish Date')</th>
            <th scope="col">@lang('Download')</th>
        </tr>
        </thead>
        <tbody>

        @foreach($posts as $key=>$post)
            <tr>
                <td>{{ $post->id }}</td>
                <th scope="row"><a class="notice_board_title" href="{{ $post->url }}">{{ description_summary($post->name,200) }}</a></th>
                <td>{{ date('d, M Y', strtotime($post->created_at)) }}</td>
                <td>
                    @if($post->document_file)
                    <a href="{{ getImageUrl($post->document_file, ) }}" download="">@lang('Download') <i
                            class="fa-solid fa-download"></i>
                    </a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @if ($posts->total() > 0)
        {!! $posts->links(Theme::getThemeNamespace() . '::partials.pagination') !!}
    @endif
</div>
