@props([
    'label' => null,
    'color' => 'primary',
    'lite' => false,
    'outline' => false,
    'icon' => null,
])

@php
$classes = Arr::toCssClasses([
    'badge',
    "label-$color" => !$lite && !$outline,
    "bg-$color-lt" => $lite,
    "badge-outline text-$color" => $outline,
    'd-inline-flex align-items-center gap-1' => $icon,
]);

@endphp
<span {{ $attributes->class($classes) }}>
    @if($icon)
{{--        <i class="{{ $icon }}"></i>--}}
        <x-kamruldashboard::icon :name="$icon" />
    @endif

    {{ $label ?? $slot }}
</span>
