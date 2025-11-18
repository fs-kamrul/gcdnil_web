@php
    Assets::addScripts(['ckeditor'])
        ->addScriptsDirectly('vendor/Modules/KamrulDashboard/js/ckeditor/editor.js');

    $attributes['class'] = Arr::get($attributes, 'class', '') . ' form-control editor-ckeditor';
    $attributes['id'] = Arr::get($attributes, 'id', $name);
    $attributes['rows'] = Arr::get($attributes, 'rows', 4);
@endphp

{!! Form::textarea($name, DboardHelper::cleanEditorContent($value), $attributes) !!}
