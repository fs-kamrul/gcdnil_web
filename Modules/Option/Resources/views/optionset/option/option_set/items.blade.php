@php
    $wow = 0;
    $increment = 0.2;
@endphp
@foreach($option_sets as $key=>$option_set)
    @php
        $wow = ($key == 6) ? 0 : $wow+$increment;
    @endphp
    {!! Theme::partial('option.option_sets.item', ['option_set' => $option_set, 'img_slider' => true, 'wow' => $wow]) !!}
@endforeach
