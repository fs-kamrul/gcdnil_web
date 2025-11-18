@php
    $value = 1;
    $wrapper = $wrapper ?? true;
@endphp

@if($wrapper)
    <x-kamruldashboard::form-group class="{{ $wrapperClass ?? null }}">
        <input type="hidden" name="{{ $name }}" value="0">

        @include('kamruldashboard::components.form.checkbox')
    </x-kamruldashboard::form-group>
@else
    <input type="hidden" name="{{ $name }}" value="0">

    @include('kamruldashboard::components.form.checkbox')
@endif
