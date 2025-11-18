<div class="sixteen columns mb_100" id="contents">
    <div id="gallery_main_page" class=" mb_150">
        <div class="container">
            <div class="row mt-5">
                @php
                    $wow = 0;
                    $increment = 0.2;
                @endphp
                @foreach($admin_gallery_boards as $key=>$admin_gallery_board)
                    @php
                        $wow = ($key == 6) ? 0 : $wow+$increment;
                    @endphp
                    {!! Theme::partial('admin_board.admin_gallery_board.item', ['admin_gallery_board' => $admin_gallery_board, 'img_slider' => true, 'wow' => $wow]) !!}
                @endforeach

            </div>
            @if ($admin_gallery_boards->total() > 0)
                <div class="justify-content-center mb-5" style="text-align: center !important;">
                    {!! $admin_gallery_boards->links(Theme::getThemeNamespace() . '::partials.admin_board.pagination') !!}
                </div>
            @endif
        </div>
    </div>
</div>
