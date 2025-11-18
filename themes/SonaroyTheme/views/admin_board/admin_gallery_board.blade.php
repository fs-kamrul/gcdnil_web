<div class="sixteen columns mb_100" id="contents">
<div id="gallery_main_page" class="mb_150">
    <div class="container">
        <div class="row mt-5 gallery_row">
            @php
                $wow = 0;
                $increment = 0.2;
            @endphp
            @foreach($images as $key=>$image)
                @php
                    $wow = ($key == 6) ? 0 : $wow+$increment;
                @endphp
                {!! Theme::partial('admin_board.admin_gallery_board.item_array', ['image' => $image, 'img_slider' => true, 'wow' => $wow]) !!}
            @endforeach

        </div>
    </div>
</div>
</div>
