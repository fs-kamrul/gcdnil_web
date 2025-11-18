<x-kamruldashboard::form.image
    :name="$name"
    :value="$value"
    action="select-image"
    :attributes="new Illuminate\View\ComponentAttributeBag((array) Arr::get($attributes, 'attr', []))"
/>

{{--<div class="image-box">--}}
{{--    <input type="hidden" name="{{ $name }}" value="{{ $value }}" class="image-data">--}}
{{--    <div class="preview-image-wrapper @if (!Arr::get($attributes, 'allow_thumb', true)) preview-image-wrapper-not-allow-thumb @endif">--}}
{{--        <img src="{{ getImageUrl($value, Arr::get($attributes, 'allow_thumb', true) == true ? 'shortcodes' : null) }}" alt="{{ trans('kamruldashboard::base.preview_image') }}" class="preview_image" @if (Arr::get($attributes, 'allow_thumb', true)) width="150" @endif>--}}
{{--        <a class="btn_remove_image" title="{{ trans('kamruldashboard::forms.remove_image') }}">--}}
{{--            <i class="fa fa-times"></i>--}}
{{--        </a>--}}
{{--    </div>--}}
{{--    <div class="image-box-actions">--}}
{{--        <a href="#" class="btn_gallery" data-result="{{ $name }}" data-action="{{ $attributes['action'] ?? 'select-image' }}">--}}
{{--            {{ trans('kamruldashboard::forms.choose_image') }}--}}
{{--        </a>--}}
{{--    </div>--}}
{{--</div>--}}
