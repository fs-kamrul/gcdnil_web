<?php

namespace Modules\AdminBoard\Forms;

use Modules\AdminBoard\Enums\AdminStudentGuidelineStatusEnum;
use Modules\AdminBoard\Http\Models\AdminStudentGuideline;
use Modules\AdminBoard\Http\Requests\AdminStudentGuidelineRequest;
use Modules\KamrulDashboard\Forms\FieldOptions\ContentFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\DescriptionFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\NameFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\StatusFieldOption;
use Modules\KamrulDashboard\Forms\Fields\EditorField;
use Modules\KamrulDashboard\Forms\Fields\SelectField;
use Modules\KamrulDashboard\Forms\Fields\TextareaField;
use Modules\KamrulDashboard\Forms\Fields\TextField;
use Modules\KamrulDashboard\Forms\FormAbstract;

class AdminStudentGuidelineForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->setupModel(new AdminStudentGuideline())
            ->setValidatorClass(AdminStudentGuidelineRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
            ->add('document', 'file', [
                'label' => trans('adminboard::lang.document'),
//                'wrapper' => [
//                    'class' => 'form-group mb-3 col-md-12 col-xl-12',
//                ],
            ])
//            ->add('short_description', TextareaField::class, DescriptionFieldOption::make()->toArray())
//            ->add('description', EditorField::class, ContentFieldOption::make()->allowedShortcodes()->toArray())

            ->add('status', SelectField::class, StatusFieldOption::make()->choices(AdminStudentGuidelineStatusEnum::labels())->toArray())
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
