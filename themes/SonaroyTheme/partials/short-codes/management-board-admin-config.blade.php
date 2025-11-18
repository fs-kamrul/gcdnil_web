
<div class="form-group" id="image_set_data">
    <label class="control-label">{{ __('Title') }}</label>
    <input name="title" type="text" id="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
</div>
{{--<div class="form-group" id="image_set_data">--}}
{{--    <label class="control-label">{{ __('Contain') }}</label>--}}
{{--    <input name="contain" type="text" id="contain" value="{{ Arr::get($attributes, 'contain') }}" class="form-control" />--}}
{{--</div>--}}

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
@php

$number_of_slide = Arr::get($attributes, 'number_of_slide') ? Arr::get($attributes, 'number_of_slide') : 10;

@endphp
<div class="form-group">
    <label class="control-label"><?php echo __('Number of Scroll'); ?></label>
    <input name="number_of_slide" type="number" id="number_of_slide" value="{{ $number_of_slide }}" class="form-control" />
</div>

