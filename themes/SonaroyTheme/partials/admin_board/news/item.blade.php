<tr>
{{--    <td class="text-center align-middle">{{ $news->id }}</td>--}}
    <td class="text-center align-middle">{{ $wow }}</td>
    <td class="align-middle">
        <a class="text-decoration-none fw-semibold text-dark" href="{{ $news->url }}">
            {{ description_summary($news->name,200) }}
        </a>
    </td>
    <td class="align-middle">
        <span class="badge bg-light text-dark">{{ date('F d, Y', strtotime($news->created_at)) }}</span>
    </td>
{{--    <td class="text-center align-middle">--}}
{{--        @if($news->document)--}}
{{--            <a href="{{ getImageUrl($news->document, 'adminboard/adminnoticeboard' ) }}" download="" class="btn btn-success btn-sm">--}}
{{--                <i class="fa-solid fa-download"></i> @lang('Download')--}}
{{--            </a>--}}
{{--        @endif--}}
{{--    </td>--}}
</tr>
