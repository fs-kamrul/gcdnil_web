<?php

namespace Modules\Option\Forms;

use Modules\AdminBoard\Forms\Fields\CategoryMultiField;
use Modules\KamrulDashboard\Forms\FieldOptions\NumberFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\SelectFieldOption;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
use Modules\Option\Enums\OptionSetStatusEnum;
use Modules\Option\Http\Models\OptionClass;
use Modules\Option\Http\Models\OptionSet;
use Modules\Option\Http\Requests\OptionSetRequest;
use Modules\KamrulDashboard\Forms\FieldOptions\ContentFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\DescriptionFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\NameFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\StatusFieldOption;
use Modules\KamrulDashboard\Forms\Fields\EditorField;
use Modules\KamrulDashboard\Forms\Fields\SelectField;
use Modules\KamrulDashboard\Forms\Fields\TextareaField;
use Modules\KamrulDashboard\Forms\Fields\TextField;
use Modules\KamrulDashboard\Forms\FormAbstract;
use Modules\Option\Repositories\Interfaces\OptionClassInterface;
use Modules\Option\Repositories\Interfaces\OptionGroupInterface;

class OptionSetForm extends FormAbstract
{
    public function setup(): void
    {
        $selectedClass = [];
        if ($this->getModel()) {
            $selectedClass = $this->getModel()->subjects()->pluck('subject_id')->all();
        }

        if (! $this->formHelper->hasCustomField('categoryMulti')) {
            $this->formHelper->addCustomField('categoryMulti', CategoryMultiField::class);
        }
//        dd($selectedClass);

        $allClassRepository = app(OptionClassInterface::class);
        $allClass = $allClassRepository->advancedGet([
            'condition' => ['status' => DboardStatus::PUBLISHED],
            'order_by'  => ['order' => 'asc'],
        ])->pluck('name', 'id')->toArray();
        $allGroupRepository = app(OptionGroupInterface::class);
        $allGroup = $allGroupRepository->advancedGet([
            'condition' => ['status' => DboardStatus::PUBLISHED],
            'order_by'  => ['order' => 'asc'],
        ])->pluck('name', 'id')->toArray();

//        dd($allClass);
        $this
            ->setupModel(new OptionSet())
            ->setValidatorClass(OptionSetRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
//            ->add('photo', 'file', [
//                'label' => trans('adminboard::lang.photo'),
////                'wrapper' => [
////                    'class' => 'form-group mb-3 col-md-12 col-xl-12',
////                ],
//            ])
//            ->add('short_description', TextareaField::class, DescriptionFieldOption::make()->toArray())
//            ->add('description', EditorField::class, ContentFieldOption::make()->allowedShortcodes()->toArray())

//            ->add('class_id', SelectField::class, SelectFieldOption::make()->label(trans('table::lang.class'))->choices($allClass)->toArray())
//            ->add('group_id', SelectField::class, SelectFieldOption::make()->label(trans('option::lang.group'))->choices($allGroup)->toArray())

            ->add('class_id', SelectField::class,
                [
                    'label' => trans('table::lang.class'),
                    'wrapper' => [
                        'class' => 'form-group col-md-6 col-xl-6',
                    ],
                    'choices' => $allClass,
//                    'value' => $this->getModel()->order ?? 0,
                ])
            ->add('group_id', SelectField::class,
                [
                    'label' => trans('option::lang.group'),
                    'wrapper' => [
                        'class' => 'form-group col-md-6 col-xl-6',
                    ],
                    'choices' => $allGroup,
    //                    'value' => $this->getModel()->order ?? 0,
                ])

            ->add('subjects[]', 'categoryMulti', [
                'label' => trans('option::lang.subject'),
                'required' => true,
                'choices' => get_subject_list_class(),
                'value' => old('subjects', $selectedClass),
            ])

            ->add('status', SelectField::class, StatusFieldOption::make()->choices(OptionSetStatusEnum::labels())->toArray())
            ->add('selected_subjects', 'number', NumberFieldOption::make()->label(__('option::lang.selected_subjects'))->required()->toArray())
            ->add('order', 'text', [
                'label' => trans('adminboard::lang.order'),
//                'wrapper' => [
//                    'class' => 'form-group col-md-6 col-xl-6',
//                ],
                'attr' => [
                    'placeholder' => trans('adminboard::lang.order'),
//                    'data-counter' => 25,educations
                ],
                'value' => $this->getModel()->order ?? 0,
            ])
            ->setBreakFieldPoint('status');
    }
}
