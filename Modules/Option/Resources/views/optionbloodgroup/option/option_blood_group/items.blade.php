@php
    $wow = 0;
    $increment = 0.2;
@endphp
@foreach($option_blood_groups as $key=>$option_blood_group)
    @php
        $wow = ($key == 6) ? 0 : $wow+$increment;
    @endphp
    {!! Theme::partial('option.option_blood_groups.item', ['option_blood_group' => $option_blood_group, 'img_slider' => true, 'wow' => $wow]) !!}
@endforeach
