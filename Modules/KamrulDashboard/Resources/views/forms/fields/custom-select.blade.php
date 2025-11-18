{{--@if ($showLabel && $showField)--}}
{{--    @if ($options['wrapper'] !== false)--}}
{{--        <div {!! $options['wrapperAttrs'] !!}>--}}
{{--    @endif--}}
{{--@endif--}}

{{--@if ($showLabel && $options['label'] !== false && $options['label_show'])--}}
{{--    {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}--}}
{{--@endif--}}

{{--@if ($showField)--}}
{{--    @php--}}
{{--        Arr::set($options['attr'], 'class', Arr::get($options['attr'], 'class') . ' ui-select');--}}
{{--        $emptyVal = $options['empty_value'] ? ['' => $options['empty_value']] : null;--}}
{{--    @endphp--}}
{{--    {!! Form::customSelect($name, (array)$emptyVal + $options['choices'], $options['selected'], $options['attr']) !!}--}}
{{--    @include('kamruldashboard::forms.partials.help-block')--}}
{{--@endif--}}

{{--@include('kamruldashboard::forms.partials.errors')--}}

{{--@if ($showLabel && $showField)--}}
{{--    @if ($options['wrapper'] !== false)--}}
{{--        </div>--}}
{{--    @endif--}}
{{--@endif--}}
<x-kamruldashboard::form.field
    :showLabel="$showLabel"
    :showField="$showField"
    :options="$options"
    :name="$name"
    :prepend="$prepend ?? null"
    :append="$append ?? null"
    :showError="$showError"
    :nameKey="$nameKey"
>
    {!! Form::customSelect(
        $name,
        ($options['empty_value'] ? ['' => $options['empty_value']] : []) + $options['choices'],
        $options['selected'] ?: $options['default_value'],
        $options['attr'],
        Arr::get($options, 'optionAttrs', []),
        Arr::get($options, 'optgroupsAttributes', []),
    ) !!}
</x-kamruldashboard::form.field>
