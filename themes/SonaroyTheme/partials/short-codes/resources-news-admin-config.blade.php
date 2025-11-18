<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
</div>
<div class="form-group">
    <label class="control-label">{{ __('Post Type') }}</label>
    <select class="form-control"
            name="post_types_id">
        <option value="">{{ __('-- select --') }}</option>
        @foreach($post_types as $post_type)
            <option value="{{ $post_type->id }}" @if ($post_type->id == Arr::get($attributes, 'post_types_id')) selected @endif>{{ $post_type->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label class="control-label">{{ __('Button Label ') }}</label>
    <input name="button_label" value="{{ Arr::get($attributes, 'button_label') }}" class="form-control" />
</div>
<div class="form-group">
    <label class="control-label">{{ __('Button Url ') }}</label>
    <input name="button_url" value="{{ Arr::get($attributes, 'button_url') }}" class="form-control" />
</div>
