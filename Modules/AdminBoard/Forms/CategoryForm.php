<?php

namespace Modules\AdminBoard\Forms;


use Modules\AdminBoard\Enums\AdminBoardEnum;
use Modules\AdminBoard\Enums\AdminCategoryStatusEnum;
use Modules\AdminBoard\Http\Models\AdminCategory;
use Modules\KamrulDashboard\Forms\FieldOptions\DescriptionFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\NameFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\StatusFieldOption;
use Modules\KamrulDashboard\Forms\Fields\SelectField;
use Modules\KamrulDashboard\Forms\Fields\TextareaField;
use Modules\KamrulDashboard\Forms\Fields\TextField;
use Modules\KamrulDashboard\Forms\FormAbstract;
use Modules\Post\Http\Requests\CategoryRequest;

class CategoryForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->setupModel(new AdminCategory())
            ->setValidatorClass(CategoryRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
            ->add('description', TextareaField::class, DescriptionFieldOption::make()->toArray())
            ->add('is_default', 'onOff', [
                'label' => trans('kamruldashboard::forms.is_default'),
                'default_value' => false,
            ])
//            ->choices(AdminCategoryStatusEnum::labels())
            ->add('adminboard', SelectField::class, StatusFieldOption::make()->choices(AdminBoardEnum::labels())->label(__('adminboard::admin_board.chose_module'))->toArray())
            ->add('status', SelectField::class, StatusFieldOption::make()->choices(AdminCategoryStatusEnum::labels())->toArray())
            ->setBreakFieldPoint('status');
    }
}
