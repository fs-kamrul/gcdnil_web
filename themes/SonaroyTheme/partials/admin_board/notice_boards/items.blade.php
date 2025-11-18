@php
    $wow = 0;
    $increment = 0.2;
@endphp
@foreach($notice_boards as $key=>$notice_board)
    @php
        $wow = ($key == 6) ? 0 : $wow+$increment;
    @endphp
    {!! Theme::partial('admin_board.notice_boards.item', ['notice_board' => $notice_board, 'img_slider' => true, 'wow' => $wow]) !!}
@endforeach
