<div class="form-group mb-3">
    <label class="control-label">{{ trans('simpleslider::simple-slider.select_slider') }}</label>
    {!! Form::customSelect('key', $sliders, Arr::get($attributes, 'key')) !!}
</div>
