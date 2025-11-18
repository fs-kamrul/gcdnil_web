@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif
@endif

@if ($showLabel && $options['label'] !== false && $options['label_show'])
    {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
@endif

@if ($showField)
{{--    {!! Form::mediaImage($name, $options['value']) !!}--}}
    @include('kamruldashboard::forms.partials.help-block')
@endif

@include('kamruldashboard::forms.partials.errors')

@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif
