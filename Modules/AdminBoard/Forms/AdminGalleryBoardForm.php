<?php

namespace Modules\AdminBoard\Forms;

use Modules\AdminBoard\Enums\AdminGalleryBoardStatusEnum;
use Modules\AdminBoard\Http\Models\AdminGalleryBoard;
use Modules\AdminBoard\Http\Requests\AdminGalleryBoardRequest;
use Modules\KamrulDashboard\Forms\FieldOptions\ContentFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\DescriptionFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\MediaImagesFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\NameFieldOption;
use Modules\KamrulDashboard\Forms\FieldOptions\StatusFieldOption;
use Modules\KamrulDashboard\Forms\Fields\EditorField;
use Modules\KamrulDashboard\Forms\Fields\MediaImagesField;
use Modules\KamrulDashboard\Forms\Fields\SelectField;
use Modules\KamrulDashboard\Forms\Fields\TextareaField;
use Modules\KamrulDashboard\Forms\Fields\TextField;
use Modules\KamrulDashboard\Forms\FormAbstract;

class AdminGalleryBoardForm extends FormAbstract
{
    public function setup(): void
    {

        $selectedGallery = [];
        $gallery_id = null;
        if ($this->getModel()) {
            $selectedGallery = $this->getModel()->AdminGalleryParameter->pluck('name','id')->toarray();
            $gallery_id = $this->getModel()->id;
        }

//        dd($gallery_id);

        $this
            ->setupModel(new AdminGalleryBoard())
            ->setValidatorClass(AdminGalleryBoardRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
            ->add('photo', 'file', [
                'label' => trans('adminboard::lang.photo'),
//                'wrapper' => [
//                    'class' => 'form-group mb-3 col-md-12 col-xl-12',
//                ],
            ])
//            ->add('id', MediaImagesField::class, MediaImagesFieldOption::make()->toArray())

            ->add('pics_file[]', MediaImagesField::class, [
                'label' => trans('adminboard::lang.images'),
                'required' => false,
                'choices' => $selectedGallery,
                'value' => old('dropzone', $gallery_id),
            ])
//            ->add('short_description', TextareaField::class, DescriptionFieldOption::make()->toArray())
//            ->add('description', EditorField::class, ContentFieldOption::make()->allowedShortcodes()->toArray())

            ->add('status', SelectField::class, StatusFieldOption::make()->choices(AdminGalleryBoardStatusEnum::labels())->toArray())
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
