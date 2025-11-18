@php
    $layout = theme_option('product_list_layout');

    $requestLayout = request()->input('layout');
    if ($requestLayout && in_array($requestLayout, array_keys(get_product_single_layouts()))) {
        $layout = $requestLayout;
    }

    $layout = ($layout && in_array($layout, array_keys(get_product_single_layouts()))) ? $layout : 'product-full-width';
@endphp

<div class="all_venue_wrapper">
    @forelse ($posts as $post)
            @include(Theme::getThemeNamespace() . '::views.venue.includes.venue-item', compact('post'))
    @empty
        <div class="tab-pane mb-5" id="pills-picnic" role="tabpanel" aria-labelledby="pills-picnic-tab"
             tabindex="0">
           {{ __('No Venues found!') }}
        </div>
    @endforelse
</div>
{{--        @if ($posts->total() > 0)--}}
{{--            <div class="mb_100">--}}
{{--            {!! $posts->withQueryString()->onEachSide(1)->links(Theme::getThemeNamespace() . '::partials.custom-pagination') !!}--}}
{{--            </div>--}}
{{--        @endif--}}
