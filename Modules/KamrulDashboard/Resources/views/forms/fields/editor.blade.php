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
    {!! Form::editor($name, $options['value'], $options['attr']) !!}
</x-kamruldashboard::form.field>

{{--@if ($showLabel && $showField)--}}
{{--    @if ($options['wrapper'] !== false)--}}
{{--        <div {!! $options['wrapperAttrs'] !!}>--}}
{{--    @endif--}}
{{--@endif--}}

{{--@if ($showLabel && $options['label'] !== false && $options['label_show'])--}}
{{--    {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}--}}
{{--@endif--}}

{{--@if ($showField)--}}
{{--    {!! Form::editor($name, $options['value'], $options['attr']) !!}--}}
{{--    @include('kamruldashboard::forms.partials.help-block')--}}
{{--@endif--}}

{{--@include('kamruldashboard::forms.partials.errors')--}}

{{--@if ($showLabel && $showField)--}}
{{--    @if ($options['wrapper'] !== false)--}}
{{--        </div>--}}
{{--    @endif--}}
{{--@endif--}}
