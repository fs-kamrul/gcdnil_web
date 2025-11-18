@props([
    'id' => null,
    'label' => null,
    'name' => null,
    'value' => old($name),
    'helperText' => null,
    'errorKey' => $name,
    'mode' => null,
])

@php
    $id = $id ?: $name . '_' . md5($name);
    $mode = $mode === 'html' ? 'htmlmixed' : $mode;

    Assets::addStylesDirectly([
            'kamruldashboard/libraries/codemirror/lib/codemirror.css',
            'kamruldashboard/libraries/codemirror/addon/hint/show-hint.css'
        ])
        ->addScriptsDirectly([
            'kamruldashboard/libraries/codemirror/lib/codemirror.js',
            'kamruldashboard/libraries/codemirror/addon/hint/show-hint.js',
            'kamruldashboard/libraries/codemirror/addon/hint/anyword-hint.js',
            'kamruldashboard/libraries/codemirror/addon/display/autorefresh.js',
        ]);

    switch ($mode) {
        case 'htmlmixed':
            Assets::addScriptsDirectly([
                'kamruldashboard/libraries/codemirror/mode/htmlmixed.js',
                'kamruldashboard/libraries/codemirror/mode/css.js',
                'kamruldashboard/libraries/codemirror/mode/javascript.js',
                'kamruldashboard/libraries/codemirror/mode/xml.js',
                'kamruldashboard/libraries/codemirror/addon/hint/xml-hint.js',
                'kamruldashboard/libraries/codemirror/addon/hint/html-hint.js',
                'kamruldashboard/libraries/codemirror/addon/hint/css-hint.js',
                'kamruldashboard/libraries/codemirror/addon/hint/javascript-hint.js',
            ]);
            break;

        case 'css':
            Assets::addScriptsDirectly([
                'kamruldashboard/libraries/codemirror/mode/css.js',
                'kamruldashboard/libraries/codemirror/addon/hint/css-hint.js',
            ]);
            break;

        case 'javascript':
            Assets::addScriptsDirectly([
                'kamruldashboard/libraries/codemirror/mode/javascript.js',
                'kamruldashboard/libraries/codemirror/addon/hint/javascript-hint.js',
            ]);
            break;
    }
@endphp

<x-kamruldashboard::form-group>
    @if ($label)
        <x-kamruldashboard::form.label
            :label="$label"
            :for="$id"
        />
    @endif

    <textarea
        {{ $attributes->merge(['name' => $name, 'class' => 'form-control', 'id' => $id, 'data-bb-code-editor' => '', 'data-mode' => $mode]) }}
    >{{ $value ?: $slot }}</textarea>

    @if ($helperText)
        <x-kamruldashboard::form.helper-text class="mt-2">{!! $helperText !!}</x-kamruldashboard::form.helper-text>
    @endif

    <x-kamruldashboard::form.error :key="$errorKey" />
</x-kamruldashboard::form-group>
