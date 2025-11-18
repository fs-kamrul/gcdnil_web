
<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 wow fadeInUp" data-wow-delay="@isset($wow) {{ $wow . 's' }} @endisset">
    <div class="gallery_folder">
        <a href="{{ $image }}">
            <img src="{{ $image }}" alt="{{ $image }}" />
        </a>
        <div class="overlay">
{{--            <p>{{ description_summary($admin_gallery_board->name, 30) }}</p>--}}
        </div>
    </div>
</div>
