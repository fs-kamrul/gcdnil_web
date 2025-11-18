@php
    Assets::addStyles(['color_picker'])
        ->addScripts(['color_picker']);
@endphp
<div class="form-group col-lg-{{ $col }} col-md-{{ $col }} mb-5">
        <p class="mb-1">@lang('kamruldashboard::lang.'.$name)</p>
        <div class="form-group">
        {!! Form::text($name, $value, array_merge(['class' => 'complex-colorpicker form-control'], $attributes)) !!}
    </div>
</div>

