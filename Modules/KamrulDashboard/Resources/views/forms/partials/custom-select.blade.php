{{--<div class="ui-select-wrapper">--}}
{{--    @php--}}
{{--        Arr::set($selectAttributes, 'class', Arr::get($selectAttributes, 'class') . ' ui-select');--}}
{{--    @endphp--}}
{{--    {!! Form::select($name, $list, $selected, $selectAttributes, $optionsAttributes, $optgroupsAttributes) !!}--}}
{{--</div>--}}
@php
    Arr::set($selectAttributes, 'class', Arr::get($selectAttributes, 'class') . ' form-select');
    $choices = $list ?? $choices;

    if ($optionsAttributes && ! is_array($optionsAttributes)) {
        $optionsAttributes = [];
    }
@endphp

{!! Form::select(
    $name,
    $choices,
    $selected,
    $selectAttributes,
    $optionsAttributes,
    $optgroupsAttributes,
) !!}
