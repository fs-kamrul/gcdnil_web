<div class="form-group">
    <label for="layout" class="control-label">{{ __('Mentor') }}</label>
    {!! Form::customSelect('mentor', get_product_mentors(), $mentor, ['class' => 'form-control', 'id' => 'mentor']) !!}
</div>
