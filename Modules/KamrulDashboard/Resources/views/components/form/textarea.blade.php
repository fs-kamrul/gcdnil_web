@props([
    'id' => null,
    'label' => null,
    'name' => null,
    'value' => old($name),
    'helperText' => null,
    'errorKey' => $name,
])

@php
    $id = $attributes->get('id', $name) ?? Str::random(8);

    $classes = Arr::toCssClasses(['form-control', 'is-invalid' => $errors->has($errorKey)]);
@endphp

<x-kamruldashboard::form-group>
    @if ($label)
        <x-kamruldashboard::form.label
            :label="$label"
            :for="$id"
        />
    @endif

    <textarea {{ $attributes->merge(['name' => $name, 'id' => $id])->class($classes) }}>{{ $value ?: $slot }}</textarea>

    @if ($helperText)
        <x-kamruldashboard::form.helper-text>{!! $helperText !!}</x-kamruldashboard::form.helper-text>
    @endif

    <x-kamruldashboard::form.error :key="$errorKey" />
</x-kamruldashboard::form-group>
