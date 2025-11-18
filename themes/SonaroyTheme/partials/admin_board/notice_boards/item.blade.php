<tr>
{{--    <td class="text-center align-middle">{{ $notice_board->id }}</td>--}}
    <td class="text-center align-middle">{{ $wow }}</td>
    <td class="align-middle">
        <a class="text-decoration-none fw-semibold text-dark" href="{{ $notice_board->url }}">
            {{ description_summary($notice_board->name,200) }}
        </a>
    </td>
    <td class="align-middle">
        <span class="badge bg-light text-dark">{{ date('d, M Y', strtotime($notice_board->created_at)) }}</span>
    </td>
    <td class="text-center align-middle">
        @if($notice_board->document)
            <a href="{{ getImageUrl($notice_board->document, 'adminboard/adminnoticeboard' ) }}" download="" class="btn btn-success btn-sm">
                <i class="fa-solid fa-download"></i> @lang('Download')
            </a>
        @endif
    </td>
</tr>
