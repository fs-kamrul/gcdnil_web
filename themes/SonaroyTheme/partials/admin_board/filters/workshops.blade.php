@php
    $project_route = empty($route) ?  route('public.adminworkshop') : $route;
@endphp
<form action="{{ $project_route }}" method="GET">
    <div class="hero-search-content hero-search-filter-wrapper">
        <div class="hero-search-filters-group">
            <div class="form-group simple">
{{--                {!! Theme::partial('admin_board.filters.location_country') !!}--}}
            </div>

            <div class="form-group simple">
{{--                {!! Theme::partial('admin_board.filters.location_state') !!}--}}
            </div>

            <div class="form-group simple">
{{--                {!! Theme::partial('admin_board.filters.location_city') !!}--}}
            </div>

            <div class="form-group simple">
                <div class="simple-input">
{{--                    {!! Theme::partial('admin_board.filters.categories') !!}--}}
                </div>
            </div>
        </div>

        <div class="search-action-wrapper">
            <button class="btn search-btn" type="submit">{{ __('Search') }}</button>
        </div>
    </div>
</form>
