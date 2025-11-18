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

class TeamForm extends FormAbstract
{
    public function setup(): void
    {
//        $resize = $this->formOptions['resize'];
//        $alertMessage = __('adminboard::lang.image_size_note', ['height' => $resize[0], 'width' => $resize[1], 'max' => DboardHelper::humanKbFilesize(1024)]);
//        dd($this->formOptions['resize']);
        $selectedCategories = [];
        if ($this->getModel()) {
            $selectedCategories = $this->getModel()->categories()->pluck('category_id')->all();
        }


        if (! $this->formHelper->hasCustomField('categoryMulti')) {
            $this->formHelper->addCustomField('categoryMulti', CategoryMultiField::class);
        }

        $educations = AdminEducation::query()->select(['id', 'name'])->get();
        $selectedEducations = [];
        if ($this->getModel()) {
            $selectedEducations = $this->getModel()->admin_educations()->select('admin_educations.id', 'name_title')->get();
        }
//        dd($selectedEducations);

        $this
            ->setupModel(new AdminTeam())
            ->setValidatorClass(TeamRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
            ->add('photo', 'file', [
                'label' => trans('adminboard::lang.photo'),
                'wrapper' => [
                    'class' => 'form-group mb-3 col-md-6 col-xl-6',
                ],
            ])
            ->add('designation', 'text', [
                'label' => trans('adminboard::lang.designation'),
                'wrapper' => [
                    'class' => 'form-group mb-3 col-md-6 col-xl-6',
                ],
                'attr' => [
                    'placeholder' => trans('adminboard::lang.designation'),
//                    'data-counter' => 25,
                ],
            ])
            ->add('email', 'text', [
                'label' => trans('adminboard::lang.email'),
                'wrapper' => [
                    'class' => 'form-group col-md-6 col-xl-6',
                ],
                'attr' => [
                    'placeholder' => trans('adminboard::lang.email'),
//                    'data-counter' => 25,
                ],
            ])
            ->add('phone', 'text', [
                'label' => trans('adminboard::lang.phone'),
                'wrapper' => [
                    'class' => 'form-group col-md-6 col-xl-6',
                ],
                'attr' => [
                    'placeholder' => trans('adminboard::lang.phone'),
//                    'data-counter' => 25,
                ],
            ])
            ->add('index_no', 'text', [
                'label' => trans('adminboard::lang.index_no'),
                'wrapper' => [
                    'class' => 'form-group col-md-6 col-xl-6',
                ],
                'attr' => [
                    'placeholder' => trans('adminboard::lang.index_no'),
//                    'data-counter' => 25,
                ],
            ])
            ->add('father_name', 'text', [
                'label' => trans('adminboard::lang.father_name'),
                'wrapper' => [
                    'class' => 'form-group col-md-6 col-xl-6',
                ],
                'attr' => [
                    'placeholder' => trans('adminboard::lang.father_name'),
                ],
            ])
            ->add('mother_name', 'text', [
                'label' => trans('adminboard::lang.mother_name'),
                'wrapper' => [
                    'class' => 'form-group col-md-6 col-xl-6',
                ],
                'attr' => [
                    'placeholder' => trans('adminboard::lang.mother_name'),
                ],
            ])
            ->add('dob', 'date', [
                'label' => trans('adminboard::lang.dob'),
                'wrapper' => [
                    'class' => 'form-group col-md-6 col-xl-6',
                ],
                'attr' => [
                    'placeholder' => trans('adminboard::lang.dob'),
                ],
            ])
            ->add('office_address', 'text', [
                'label' => trans('adminboard::lang.office_address'),
                'wrapper' => [
                    'class' => 'form-group col-md-6 col-xl-6',
                ],
                'attr' => [
                    'placeholder' => trans('adminboard::lang.office_address'),
                ],
            ])
            ->add('facebook_id', 'text', [
                'label' => trans('adminboard::lang.facebook_id'),
                'wrapper' => [
                    'class' => 'form-group col-md-6 col-xl-6',
                ],
                'attr' => [
                    'placeholder' => trans('adminboard::lang.facebook_id'),
//                    'data-counter' => 25,
                ],
            ])
            ->add('google_site', 'text', [
                'label' => trans('adminboard::lang.google_site'),
                'wrapper' => [
                    'class' => 'form-group col-md-6 col-xl-6',
                ],
                'attr' => [
                    'placeholder' => trans('adminboard::lang.google_site'),
//                    'data-counter' => 25,
                ],
            ])
            ->add('linkedin_id', 'text', [
                'label' => trans('adminboard::lang.linkedin_id'),
                'wrapper' => [
                    'class' => 'form-group col-md-6 col-xl-6',
                ],
                'attr' => [
                    'placeholder' => trans('adminboard::lang.linkedin_id'),
//                    'data-counter' => 25,educations
                ],
            ])
            ->add('short_description', TextareaField::class, DescriptionFieldOption::make()->toArray())
            ->add('description', EditorField::class, ContentFieldOption::make()->allowedShortcodes()->toArray())

            ->addMetaBoxes([
                'educations' => [
                    'title' => trans('adminboard::lang.admineducation'),
                    'content' => view(
                        'adminboard::partials.form-educations',
                        compact('educations', 'selectedEducations')
                    ),
                    'priority' => 0,
                ],
            ])
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
                'choices' => get_teams_with_children('team'),
                'value' => old('categories', $selectedCategories),
            ])
            ->setBreakFieldPoint('status');
    }
}
