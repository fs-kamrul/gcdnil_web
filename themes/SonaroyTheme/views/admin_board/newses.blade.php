@php
//    $news_category = get_news_with_children('noticeboard');
@endphp
@php
    $wow = 0.3;
    $increment = 0;
@endphp
<div class="sixteen columns mb_100">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-3 mt-3">
                <thead class="table-dark">
                <tr>
                    <th scope="col" class="text-center">@lang('SL')</th>
                    <th scope="col">@lang('Title')</th>
                    <th scope="col">@lang('Publish Date')</th>
{{--                    <th scope="col" class="text-center">@lang('Download')</th>--}}
                </tr>
                </thead>
                <tbody>

                @foreach($newses as $key=>$news)
                    @php
                        $wow = ($news->currentPage() - 1) * $news->perPage() + $key + 1;
                        // $wow = ($key == 6) ? 0 : $wow+$increment;
                    @endphp
                    {!! Theme::partial('admin_board.news.item', ['news' => $news, 'img_slider' => true, 'wow' => $wow]) !!}
                @endforeach
                </tbody>
            </table>
            @if ($newses->total() > 0)
                {!! $newses->links(Theme::getThemeNamespace() . '::partials.admin_board.pagination') !!}
            @endif
        </div>
    </div>
</div>
