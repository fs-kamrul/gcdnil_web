<?php

namespace Modules\Post\Forms;


use Modules\KamrulDashboard\Forms\FormAbstract;
use Modules\Post\Http\Models\Page;
use Modules\Post\Http\Requests\PageRequest;

class PageForm extends FormAbstract
{

    /**
     * @var string
     */
    protected $template = 'kamruldashboard::forms.form-tabs';

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {
        $this
            ->setupModel(new Page())
            ->setValidatorClass(PageRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('kamruldashboard::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('kamruldashboard::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('description', 'textarea', [
                'label'      => trans('kamruldashboard::forms.description'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'rows'         => 4,
                    'placeholder'  => trans('kamruldashboard::forms.description_placeholder'),
                    'data-counter' => 400,
                ],
            ])
//            ->add('content', 'editor', [
//                'label'      => trans('kamruldashboard::forms.description'),
//                'label_attr' => ['class' => 'control-label required'],
//                'attr'       => [
//                    'placeholder'     => trans('kamruldashboard::forms.description_placeholder'),
//                    'with-short-code' => true,
//                ],
//            ])
            ->add('status', 'customSelect', [
                'label'      => trans('kamruldashboard::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => array_status(),
            ])
            ->add('template', 'customSelect', [
                'label'      => trans('kamruldashboard::forms.template'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => get_page_templates(),
            ])
//            ->add('image', 'mediaImage', [
//                'label'      => trans('kamruldashboard::forms.image'),
//                'label_attr' => ['class' => 'control-label'],
//            ])
            ->setBreakFieldPoint('status');
    }
}
