<div class="faq">
    <div class="container">
        <div class="row justify-content-center">
            @php
                $wow = 0;
                $increment = 0.2;
            @endphp
            @foreach($admin_clubs as $key=>$admin_club)
                @php
                    $wow = ($key == 6) ? 0 : $wow+$increment;
                @endphp
                {!! Theme::partial('admin_board.admin_club.item', ['admin_club' => $admin_club, 'img_slider' => true, 'wow' => $wow]) !!}
            @endforeach
        </div>
        @if ($admin_clubs->total() > 0)
            <div class="justify-content-center" style="text-align: center !important;">
                {!! $admin_clubs->links(Theme::getThemeNamespace() . '::partials.admin_board.pagination') !!}
            </div>
        @endif
    </div>
</div>
