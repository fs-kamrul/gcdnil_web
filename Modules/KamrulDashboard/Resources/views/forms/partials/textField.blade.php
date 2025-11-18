<div class="form-group col-md-{{ $col }} col-xl-{{ $col }}">
    <label>@lang($module.'::lang.'.$name)</label>
    {!! Form::text($name, $value, array_merge(['class' => 'form-control'], $attributes)) !!}
    @error($name)
    {!! getValidationMessage()!!}
    @enderror
    @if(isset($help_block) && $help_block != null)
    {!! Form::helper($help_block) !!}
    @endif
</div>

