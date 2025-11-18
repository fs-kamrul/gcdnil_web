<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
    <input name="image" type="hidden" id="shortcode_image" value="{{ Arr::get($attributes, 'image') }}" class="form-control" />
</div>

{{--<div class="form-group">--}}
{{--    <label class="control-label">{{ __('Category') }}</label>--}}
{{--    <select class="form-control"--}}
{{--            name="category_id">--}}
{{--        <option value="">{{ __('-- select --') }}</option>--}}
{{--        @foreach($categories as $category)--}}
{{--            <option value="{{ $category->id }}" @if ($category->id == Arr::get($attributes, 'category_id')) selected @endif>{{ $category->name }}</option>--}}
{{--        @endforeach--}}
{{--    </select>--}}
{{--</div>--}}
{{--@php--}}
{{--    $number = array();--}}
{{--    for ($i=1; $i<=12; $i++){--}}
{{--        $number[$i] = $i;--}}
{{--    }--}}
{{--@endphp--}}
{{--<div class="form-group">--}}
{{--    <label class="control-label"><?php echo __('Number of Scroll'); ?></label>--}}
{{--    <?php echo Form::Select('number_of_slide', $number, Arr::get($attributes, 'number_of_slide'), ['class' => 'form-control', 'id' => 'number_of_slide']); ?>--}}
{{--</div>--}}
