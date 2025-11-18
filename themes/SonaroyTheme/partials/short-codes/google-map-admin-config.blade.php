<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input name="title" type="text" id="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
</div><div class="form-group">
    <label class="control-label">{{ __('Class') }}</label>
    <input name="title_class" type="text" id="title_class" value="{{ Arr::get($attributes, 'title_class') }}" class="form-control" />
</div>
<div class="form-group mb-3">
    <label class="control-label">{{ __('Address') }}</label>
    {!! Form::input('text', 'address', $content, ['class' => 'form-control', 'data-shortcode-attribute' => 'content', 'placeholder' => 'Rd No 14, Dhaka 1209, Daffodil International School']) !!}
</div>
