@props(['src', 'alt' => trans('kamruldashboard::lang.preview_image')])

<img
    {{ $attributes }}
    src="{{ $src }}"
    alt="{{ $alt }}"
/>
