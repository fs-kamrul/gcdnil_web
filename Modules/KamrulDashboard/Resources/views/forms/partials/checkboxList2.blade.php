<?php
/**
 * @var string $value
 */
$value = isset($value) ? (array)$value : [];
//dd($categories);
?>
@if($categories)
    <ul>
        @foreach($categories as $category)
            @if($category->id != $currentId)
                <li value="{{ $category->id ?? '' }}"
                    {{ $category->id == $value ? 'selected' : '' }}>
                    {!! Form::customCheckbox([
                        [
                            $name, $category->id, $category->name, in_array($category->id, $value),
                        ]
                    ]) !!}
                    @include('kamruldashboard::forms.partials.checkboxList2', [
                        'categories' => $category->child_cats,
                        'value'      => $value,
                        'currentId'  => $currentId,
                        'name'       => $name
                    ])
                </li>
            @endif
        @endforeach
    </ul>
@endif
