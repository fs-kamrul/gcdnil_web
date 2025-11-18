<?php

namespace Modules\KamrulDashboard\Providers;

use Form;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
//use Kris\LaravelFormBuilder\FormBuilder;

class FormServiceProvider extends ServiceProvider
{
    /**
     * @throws BindingResolutionException
     */
    public function boot() :void
    {

//        dd( __DIR__.'/../Resources/views');
//        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'kamruldashboard');
//        $this->app->singleton(FormBuilder::class, function ($app) {
//            return new FormBuilder($app['html'], $app['url'], $app['view'], $app['session.store']->token());
//        });
        Form::component('error', 'kamruldashboard::forms.partials.error', [
            'name',
            'errors' => null,
        ]);
        Form::component('editor', 'kamruldashboard::forms.partials.editor', [
            'name',
            'value'      => null,
            'attributes' => [],
        ]);
        Form::component('ckeditor', 'kamruldashboard::forms.partials.ckeditor', [
            'name',
            'value'      => null,
            'attributes' => [],
        ]);
        Form::component('status', 'kamruldashboard::forms.partials.status', [
            'name'          =>'status',
            'list'          => null,
            'selected'      => null,
            'attributes'    => [],
            'options'       =>  [
                'label'         => 'label',
                'label_attr'    => ['class' => 'control-label'],
            ],
            'selected_row'   => 12,
        ]);
        Form::component('modalAction', 'kamruldashboard::forms.partials.modal', [
            'name',
            'title',
            'type'        => null,
            'content'     => null,
            'action_id'   => null,
            'action_name' => null,
            'modal_size'  => null,
        ]);
        Form::component('permalink', 'kamruldashboard::slug.permalink', [
            'name',
            'value'      => null,
            'id'         => null,
            'prefix'     => '',
            'preview'    => false,
            'attributes' => [],
            'editable'   => true,
            'model' => '',
        ]);
        Form::component('customSelect', 'kamruldashboard::forms.partials.custom-select', [
            'name',
            'choices'             => [],
//            'list'                => [],
            'selected'            => null,
            'selectAttributes'    => [],
            'optionsAttributes'   => [],
            'optgroupsAttributes' => [],
        ]);
        Form::component('customSelect2', 'kamruldashboard::forms.partials.custom-select2', [
            'name',
            'list'                => [],
            'selected'            => null,
            'selectAttributes'    => [],
            'optionsAttributes'   => [],
            'optgroupsAttributes' => [],
        ]);
        Form::component('googleFonts', 'kamruldashboard::forms.partials.google-fonts', [
            'name',
            'selected'          => null,
            'selectAttributes'  => [],
            'optionsAttributes' => [],
        ]);

        Form::component('helper', 'kamruldashboard::forms.partials.helper', ['content']);
        Form::component('formActions', 'kamruldashboard::forms.partials.form-actions2', [
            'title',
            'only_save'     => false,
            'icon'          => null,
            'saveIcon'      => null,
        ]);
        Form::component('onOff', 'kamruldashboard::forms.partials.on-off', [
            'name',
            'value' => false,
            'attributes' => [],
        ]);
        Form::component('onOffV2', 'kamruldashboard::forms.partials.on-off-v2', [
            'name',
            'value' => false,
            'attributes' => [],
        ]);
        Form::component('help_block', 'kamruldashboard::forms.partials.help-block', [
            'options'       => []
        ]);
        Form::component('textField', 'kamruldashboard::forms.partials.textField', [
            'name',
            'value'         => null,
            'module'        => 'kamruldashboard',
            'col'           => 12,
            'attributes'    => [],
            'help_block'    => null,
        ]);
        Form::component('textField2', 'kamruldashboard::forms.partials.textField2', [
            'name',
            'value'         => null,
            'attributes'    => [],
            'options'       =>  [
                'label'         => 'label',
                'label_attr'    => ['class' => 'control-label'],
            ],
            'help_block'    => null,
        ]);

        Form::component('customColor', 'kamruldashboard::forms.partials.color', [
            'name',
            'value'      => null,
            'attributes' => [],
        ]);
        Form::component('colorPickerField', 'kamruldashboard::forms.partials.colorPickerField', [
            'name',
            'value'         => '#7ab2fa',
            'col'           => 12,
            'attributes'    => [],
        ]);
        Form::component('numberField', 'kamruldashboard::forms.partials.numberField', [
            'name',
            'value'         => null,
            'module'        => 'kamruldashboard',
            'col'           => 12,
            'attributes'    => [],
        ]);
        Form::component('numberDateField', 'kamruldashboard::forms.partials.dateField', [
            'name',
            'value'         => null,
            'module'        => 'kamruldashboard',
            'col'           => 12,
            'attributes'    => [],
        ]);
        /**
         * Custom checkbox
         * Every checkbox will not have the same name
         */
        Form::component('customCheckbox', 'kamruldashboard::forms.partials.custom-checkbox', [
            /**
             * @var array $values
             * @template: [
             *      [string $name, string $value, string $label, bool $selected, bool $disabled],
             *      [string $name, string $value, string $label, bool $selected, bool $disabled],
             *      [string $name, string $value, string $label, bool $selected, bool $disabled],
             * ]
             */
            'values',
        ]);
        Form::component('multiCheckList', 'kamruldashboard::forms.partials.checkbox', [
            'name',
            'value'         => null,
            'selected'      => null,
            'options'       =>  [
                'label'         => 'label',
                'label_attr'    => ['class' => 'control-label'],
            ],
            'attributes'    => [],

        ]);
        Form::component('multiCheckList2', 'kamruldashboard::forms.partials.checkboxList', [
            'name',
            'value'         => null,
            'selected'      => null,
            'options'       =>  [
                'label'         => 'label',
                'label_attr'    => ['class' => 'control-label'],
            ],
            'attributes'    => [],
        ]);
        Form::macro('customLabel', function($name, $value, $options = [], $escape_html = true) {
            if (isset($options['for']) && $for = $options['for']) {
                unset($options['for']);
                return Form::label($for, $value, $options, $escape_html);
            }

            return Form::label($name, $value, $options, $escape_html);
        });
        Form::component('datePicker', 'kamruldashboard::forms.fields.date', [
            'name',
            'options'       =>  [
                'label'         => 'label',
                'label_show'    => true,
                'label_attr'    => ['class' => 'control-label'],
                'attr'    => ['class' => 'control-label'],
                'value'         => 11111,
                'wrapper'       => false,
                'wrapperAttrs'  => '',
            ],
            'showLabel'     => true,
            'showField'     => true,
        ]);

        Form::component('repeater', 'kamruldashboard::forms.partials.repeater', [
            'name',
            'value' => null,
            'fields' => [],
            'attributes' => [],
        ]);
        Form::component('multiRepeater', 'kamruldashboard::forms.partials.multiRepeater', [
            'name',
            'value' => null,
            'fields' => [],
            'attributes' => [],
        ]);
//        Form::component('multiCheckList', 'kamruldashboard::forms.fields.multi-check-list', [
//            'name',
//            'showLabel'     => true,
//            'showField'     => true,
//            'options'       =>  [
//                'wrapper'       => true,
//                'wrapperAttrs'  => '',
//                'label'         => 'label',
//                'label_show'    => 'label_show',
//                'label_attr'    => [],
//                'value'         => 11111,
//            ],
//        ]);
    }
}
