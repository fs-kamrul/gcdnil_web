@php
    Assets::addScripts(['datepicker'])
                ->addStyles(['datepicker'])
@endphp
@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif
@endif

@if ($showLabel && $options['label'] !== false && $options['label_show'])
    {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
@endif

@if ($showField)
    <div class="input-group">
        {!! Form::text($name, $options['value'] ?? now()->format('m/d/Y'), array_merge($options['attr'], ['class' => Arr::get($options['attr'], 'class', '') . str_replace(Arr::get($options['attr'], 'class'), '', ' flatpickr-input')])) !!}
        <span class="input-group-append">
            <span class="input-group-text">
                <i class="fa fa-calendar"></i>
            </span>
        </span>
    </div>
{{--    @include('kamruldashboard::forms.partials.help-block')--}}
@endif

{{--@include('kamruldashboard::forms.partials.errors')--}}

@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif

@push('footer')
<script>
    flatpickr(".flatpickr-input", {
        enableTime: false,
        dateFormat: "Y-m-d",
    });
</script>
@endpush
