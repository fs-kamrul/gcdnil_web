<a href="#" class="add-curriculum-schema-items @if ($hasValue) hidden @endif">{{ trans('faq::faq.add_curriculum') }}</a>

<div class="curriculum-schema-items @if (!$hasValue) hidden @endif">
    @php
//    dd($value);
 @endphp
    {!! Form::multiRepeater('curriculum_schema_config', $value, [
        [
            'repeated'   => false,
            'type'       => 'textarea',
            'label'      => trans('faq::faq.section'),
            'label_attr' => ['class' => 'control-label required'],
            'attributes' => [
                'name'    => 'lesson',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'data-counter' => 1000,
                    'rows'         => 1,
                ],
            ],
        ],
        [
            'repeated'   => true,
            'type'       => 'textarea',
            'label'      => trans('faq::faq.lesson_title'),
            'label_attr' => ['class' => 'control-label required'],
            'attributes' => [
                'name'    => 'lesson_title',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'data-counter' => 1000,
                    'rows'         => 1,
                ],
            ],
        ],
    ]) !!}
</div>
