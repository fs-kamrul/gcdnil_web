@php
//    $number = array();
//    for ($i=1; $i<=10; $i++){
//        $number[$i] = $i;
//    }
@endphp
<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input name="title" type="text" id="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
</div>
{{--<div class="form-group">--}}
{{--    <label class="control-label">{{ __('Contain') }}</label>--}}
{{--    <textarea name="contain" class="form-control">{{ Arr::get($attributes, 'contain') }}</textarea>--}}
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
