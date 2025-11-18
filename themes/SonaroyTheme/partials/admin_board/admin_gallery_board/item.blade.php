
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
    <div class="gallery_folder">
        <a href="{{ $admin_gallery_board->url }}">
            <img src="{{ getImageUrl($admin_gallery_board->photo, 'adminboard/admingalleryboard') }}" alt="{{ $admin_gallery_board->name }}"/>
        </a>

        <span>
                                    <a href="{{ $admin_gallery_board->url }}">@lang('See More')</a>
                                </span>

        <div class="overlay">
            <p>{{ $admin_gallery_board->name }}</p>
        </div>
    </div>
</div>
