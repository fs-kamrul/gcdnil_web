@php
    $wow = 0;
    $increment = 0.2;
@endphp
@foreach($admin_gallery_boards as $key=>$admin_gallery_board)
    @php
        $wow = ($key == 6) ? 0 : $wow+$increment;
    @endphp
    {!! Theme::partial('admin_board.admin_gallery_boards.item', ['admin_gallery_board' => $admin_gallery_board, 'img_slider' => true, 'wow' => $wow]) !!}
@endforeach
