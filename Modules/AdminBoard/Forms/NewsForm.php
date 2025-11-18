<?php

namespace Modules\AdminBoard\Forms;


use Modules\AdminBoard\Enums\AdminNewsStatusEnum;
use Modules\AdminBoard\Forms\Fields\CategoryMultiField;
use Modules\AdminBoard\Http\Models\AdminEducation;
use Modules\AdminBoard\Http\Models\AdminNews;
use Modules\AdminBoard\Http\Requests\NewsRequest;
use Modules\KamrulDashboard\Forms\FieldOptions\ContentFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\DescriptionFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\NameFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\StatusFieldOption;
use Modules\KamrulDashboard\Forms\Fields\EditorField;
use Modules\KamrulDashboard\Forms\Fields\SelectField;
use Modules\KamrulDashboard\Forms\Fields\TextareaField;
use Modules\KamrulDashboard\Forms\Fields\TextField;
use Modules\KamrulDashboard\Forms\FormAbstract;

class NewsForm extends FormAbstract
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

//        $educations = AdminEducation::query()->select(['id', 'name'])->get();
//        $selectedEducations = [];
//        if ($this->getModel()) {
//            $selectedEducations = $this->getModel()->admin_educations()->select('admin_educations.id', 'name_title')->get();
//        }
//        dd($selectedEducations);

        $this
            ->setupModel(new AdminNews())
            ->setValidatorClass(NewsRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
            ->add('photo', 'file', [
                'label' => trans('adminboard::lang.photo'),
//                'wrapper' => [
//                    'class' => 'form-group mb-3 col-md-6 col-xl-6',
//                ],
            ])
            ->add('short_description', TextareaField::class, DescriptionFieldOption::make()->toArray())
            ->add('description', EditorField::class, ContentFieldOption::make()->allowedShortcodes()->toArray())

            ->add('status', SelectField::class, StatusFieldOption::make()->choices(AdminNewsStatusEnum::labels())->toArray())
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
                'choices' => get_news_with_children('news'),
                'value' => old('categories', $selectedCategories),
            ])
            ->setBreakFieldPoint('status');
    }
}
