@php
    $prefix = apply_filters(FILTER_SLUG_PREFIX, $prefix);
    $value = $value ?: old('slug');
    $endingURL = config('kamruldashboard.public_single_ending_url');
    $previewURL = str_replace('--slug--', $value, url($prefix) . '/' . config('kamruldashboard.slug_pattern')) . $endingURL . (Auth::user() && $preview ? '?preview=true' : '');
@endphp

<div id="edit-slug-box"  class="@if (empty($value) && !$errors->has($name))hidden @endif  col-md-12" >
    @if (in_array(Route::currentRouteName(), ['pages.create', 'pages.edit']) && DboardHelper::isHomepage(Route::current()->parameter('page')))
        <label class="control-label" for="current-slug">{{ trans('kamruldashboard::lang.permalink') }}:</label>
        <span id="sample-permalink" class="d-inline-block" dir="ltr">
            <a class="permalink" target="_blank" href="{{ route('public.index') }}">
                <span class="default-slug">{{ route('public.index') }}</span>
            </a>
        </span>
    @else

        <label class="control-label @if ($editable) required @endif" for="current-slug">{{ trans('kamruldashboard::lang.permalink') }}:</label>
        <span id="sample-permalink" class="d-inline-block" dir="ltr">
            <a class="permalink" target="_blank" href="{{ $previewURL }}">
                <span class="default-slug">{{ url($prefix) }}/<span id="editable-post-name">{{ $value }}</span>{{ $endingURL }}</span>
            </a>
        </span>

        @if ($editable)
            <span id="edit-slug-buttons">
                <button type="button" class="btn btn-secondary" id="change_slug">{{ trans('kamruldashboard::lang.edit') }}</button>
                <button type="button" class="save btn btn-secondary" id="btn-ok">{{ trans('kamruldashboard::lang.ok') }}</button>
                <button type="button" class="cancel button-link">{{ trans('kamruldashboard::lang.cancel') }}</button>
                @if (Auth::user() && $preview && $id)
                    <a class="btn btn-info btn-preview" target="_blank" href="{{ $previewURL }}">{{ trans('kamruldashboard::lang.preview') }}</a>
                @endif
            </span>

            <input type="hidden" id="current-slug" name="{{ $name }}" value="{{ $value }}">
{{--            {{ route('slug.create') }}--}}
            <div data-url="{{ route('slug.create') }}" data-view="{{ rtrim(str_replace('--slug--', '', url($prefix) . '/' . config('kamruldashboard.slug_pattern')), '/') . '/' }}" id="slug_id" data-id="{{ $id ?: 0 }}"></div>
            <input type="hidden" name="slug_id" value="{{ $id ?: 0 }}">
            <input type="hidden" name="is_slug_editable" value="1">
        @endif
    @endif
</div>
