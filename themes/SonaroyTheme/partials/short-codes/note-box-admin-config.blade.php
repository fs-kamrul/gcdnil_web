<div class="form-group">
    <label for="title" class="control-label">{{ __('Title') }}</label>
    <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
</div>
<div class="form-group">
    <label for="contain" class="control-label">{{ __('Contain') }}</label>
    <input name="contain" value="{{ Arr::get($attributes, 'contain') }}" class="form-control" />
</div>
@for($i=1; $i<=1; $i++)
    <div class="form-group">
        <label class="control-label">{{ __('Button Label ' . $i) }}</label>
        <input name="button_label{{ $i }}" value="{{ Arr::get($attributes, 'button_label' . $i) }}" class="form-control" />
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('Button Url ' . $i) }}</label>
        <input name="button_url{{ $i }}" value="{{ Arr::get($attributes, 'button_url' . $i) }}" class="form-control" />
    </div>
@endfor

