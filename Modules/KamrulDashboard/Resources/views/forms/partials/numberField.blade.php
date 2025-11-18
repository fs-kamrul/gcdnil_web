<div class="form-group col-md-{{ $col }} col-xl-{{ $col }}">
    <label>@lang($module.'::lang.'.$name)</label>
    {!! Form::number($name, $value, array_merge(['class' => 'form-control'], $attributes)) !!}
    @error($name)
    {!! getValidationMessage()!!}
    @enderror
</div>

