<?php

namespace Modules\AdminBoard\Forms;


use Modules\AdminBoard\Enums\AdminTeamStatusEnum;
use Modules\AdminBoard\Forms\Fields\CategoryMultiField;
use Modules\AdminBoard\Http\Models\AdminEducation;
use Modules\AdminBoard\Http\Models\AdminTeam;
use Modules\AdminBoard\Http\Requests\TeamRequest;
use Modules\KamrulDashboard\Forms\FieldOptions\ContentFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\DescriptionFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\NameFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\StatusFieldOption;
use Modules\KamrulDashboard\Forms\Fields\EditorField;
use Modules\KamrulDashboard\Forms\Fields\SelectField;
use Modules\KamrulDashboard\Forms\Fields\TextareaField;
use Modules\KamrulDashboard\Forms\Fields\TextField;
use Modules\KamrulDashboard\Forms\FormAbstract;

class NoticeBoardForm extends FormAbstract
{
    public function setup(): void
    {

        $selectedCategories = [];
        if ($this->getModel()) {
            $selectedCategories = $this->getModel()->categories()->pluck('category_id')->all();
        }


        if (! $this->formHelper->hasCustomField('categoryMulti')) {
            $this->formHelper->addCustomField('categoryMulti', CategoryMultiField::class);
        }


        $this
            ->setupModel(new AdminTeam())
            ->setValidatorClass(TeamRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
            ->add('photo', 'file', [
                'label' => trans('adminboard::lang.photo'),
                'wrapper' => [
                    'class' => 'form-group mb-3 col-md-6 col-xl-6',
                ],
            ]) ->add('document', 'file', [
                'label' => trans('adminboard::lang.document'),
                'wrapper' => [
                    'class' => 'form-group mb-3 col-md-6 col-xl-6',
                ],
            ])
            ->add('short_description', TextareaField::class, DescriptionFieldOption::make()->toArray())
            ->add('description', EditorField::class, ContentFieldOption::make()->allowedShortcodes()->toArray())

            ->add('status', SelectField::class, StatusFieldOption::make()->choices(AdminTeamStatusEnum::labels())->toArray())
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
            ->add('categories[]', 'categoryMulti', [
                'label' => trans('adminboard::lang.categories'),
                'required' => true,
                'choices' => get_teams_with_children('noticeboard'),
                'value' => old('categories', $selectedCategories),
            ])
            ->setBreakFieldPoint('status');
    }
}
