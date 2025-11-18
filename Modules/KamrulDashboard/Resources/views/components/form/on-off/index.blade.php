@php
    $options = [
        1 => trans('kamruldashboard::lang.yes'),
        0 => trans('kamruldashboard::lang.no'),
    ];
@endphp

@include('kamruldashboard::components.form.radio-list')
