@php
    $wow = 0;
    $increment = 0.2;
@endphp
@foreach($admin_clubs as $key=>$admin_club)
    @php
        $wow = ($key == 6) ? 0 : $wow+$increment;
    @endphp
    {!! Theme::partial('admin_board.admin_clubs.item', ['admin_club' => $admin_club, 'img_slider' => true, 'wow' => $wow]) !!}
@endforeach
