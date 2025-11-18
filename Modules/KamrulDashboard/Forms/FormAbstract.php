<?php

namespace Modules\KamrulDashboard\Forms;

use Assets;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Tappable;
use Modules\KamrulDashboard\Events\BeforeCreateContentEvent;
use Modules\KamrulDashboard\Events\BeforeEditContentEvent;
use Modules\KamrulDashboard\Events\BeforeUpdateContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Events\FormRendering;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Forms\Fields\AutocompleteField;
use Modules\KamrulDashboard\Forms\Fields\ColorField;
use Modules\KamrulDashboard\Forms\Fields\CustomRadioField;
use Modules\KamrulDashboard\Forms\Fields\CustomSelectField;
use Modules\KamrulDashboard\Forms\Fields\DateField;
use Modules\KamrulDashboard\Forms\Fields\EditorField;
use Modules\KamrulDashboard\Forms\Fields\HtmlField;
use Modules\KamrulDashboard\Forms\Fields\MediaFileField;
use Modules\KamrulDashboard\Forms\Fields\MediaImageField;
use Modules\KamrulDashboard\Forms\Fields\MediaImagesField;
use Modules\KamrulDashboard\Forms\Fields\OnOffField;
use Modules\KamrulDashboard\Forms\Fields\RepeaterField;
use Modules\KamrulDashboard\Forms\Fields\TimeField;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
//use JsValidator;
use Kris\LaravelFormBuilder\Fields\FormField;
use Kris\LaravelFormBuilder\Form;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Http\Models\DboardModel as DboardModelInstance;
use Modules\KamrulDashboard\Packages\Supports\Builders\Extensible;
use Modules\KamrulDashboard\Contracts\Builders\Extensible as ExtensibleContract;
use Modules\KamrulDashboard\Packages\Supports\Builders\RenderingExtensible;
use Modules\KamrulDashboard\Traits\Forms\HasCollapsible;
use Modules\KamrulDashboard\Traits\Forms\HasColumns;
use Modules\KamrulDashboard\Traits\Forms\HasMetadata;
use Throwable;

abstract class FormAbstract extends Form implements ExtensibleContract
{
    use Conditionable;
    use Tappable;
    use Extensible;
    use HasColumns;
    use HasMetadata;
    use RenderingExtensible;
    use HasCollapsible;
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $validatorClass = '';

    /**
     * @var array
     */
    protected $metaBoxes = [];

    /**
     * @var string
     */
    protected $actionButtons = '';

    /**
     * @var string
     */
    protected $breakFieldPoint = '';

    /**
     * @var bool
     */
    protected $useInlineJs = false;

    /**
     * @var string
     */
    protected $wrapperClass = 'basic-form';

    /**
     * @var string
     */
    protected $template = 'kamruldashboard::forms.form';
    protected $onlyValidatedData = false;

    protected $withoutActionButtons = false;

    /**
     * FormAbstract constructor.
     */
    public function __construct()
    {
        $this->setMethod('POST');
        $this->setFormOption('template', $this->template);
        $this->setFormOption('id', strtolower(Str::slug(Str::snake(get_class($this)))));
        $this->setFormOption('class', 'js-base-form');
    }

    public function setup(): void
    {
    }
    public function buildForm(): void
    {
        $this->withCustomFields();

        $this->setup();

        if (! $this->model) {
            $this->model = new DboardModelInstance();
        }

        $this->setupExtended();
    }
    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return array
     */
    public function getMetaBoxes(): array
    {
        uasort($this->metaBoxes, function ($before, $after) {
            if (Arr::get($before, 'priority', 0) > Arr::get($after, 'priority', 0)) {
                return 1;
            } elseif (Arr::get($before, 'priority', 0) < Arr::get($after, 'priority', 0)) {
                return -1;
            }

            return 0;
        });

        return $this->metaBoxes;
    }


    /**
     * @param string $name
     * @return string
     * @throws Throwable
     */
    public function getMetaBox($name): string
    {
        if (! Arr::get($this->metaBoxes, $name)) {
            return '';
        }

        $metaBox = $this->metaBoxes[$name];

        if ($metaBox instanceof MetaBox) {
            $metaBox = $metaBox->toArray();
        }

        if (isset($metaBox['content']) && $metaBox['content'] instanceof Closure) {
            $metaBox['content'] = call_user_func($metaBox['content'], $this->getModel());
        }

        $view = view('kamruldashboard::forms.partials.meta-box', compact('metaBox'));

        if (Arr::get($metaBox, 'render') === false) {
            return $view;
        }

        return $view->render();
//        $metaBox = $this->metaBoxes[$name];

//        return view('kamruldashboard::forms.partials.meta-box', compact('metaBox'))->render();
    }

    /**
     * @param array $boxes
     * @return $this
     */
    public function addMetaBoxes($boxes): self
    {
        if (!is_array($boxes)) {
            $boxes = [$boxes];
        }
        $this->metaBoxes = array_merge($this->metaBoxes, $boxes);

        return $this;
    }

    /**
     * @param string $name
     * @return FormAbstract
     */
    public function removeMetaBox($name): self
    {
        Arr::forget($this->metaBoxes, $name);
        return $this;
    }

    /**
     * @return string
     * @throws Throwable
     */
    public function getActionButtons(): string
    {
        if ($this->actionButtons === '') {
            return view('kamruldashboard::forms.partials.form-actions')->render();
        }

        return $this->actionButtons;
    }

    /**
     * @param string $actionButtons
     * @return $this
     */
    public function setActionButtons($actionButtons): self
    {
        $this->actionButtons = $actionButtons;

        return $this;
    }

    /**
     * @return $this
     */
    public function removeActionButtons(): self
    {
        $this->actionButtons = '';

        return $this;
    }

    /**
     * @return string
     */
    public function getBreakFieldPoint(): string
    {
        return $this->breakFieldPoint;
    }
    public function withoutActionButtons(bool $withoutActionButtons = true): static
    {
        $this->withoutActionButtons = $withoutActionButtons;

        return $this;
    }

    public function isWithoutActionButtons(): bool
    {
        return $this->withoutActionButtons;
    }

    /**
     * @param string $breakFieldPoint
     * @return $this
     */
    public function setBreakFieldPoint(string $breakFieldPoint): self
    {
        $this->breakFieldPoint = $breakFieldPoint;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUseInlineJs(): bool
    {
        return $this->useInlineJs;
    }

    /**
     * @param bool $useInlineJs
     * @return $this
     */
    public function setUseInlineJs(bool $useInlineJs): self
    {
        $this->useInlineJs = $useInlineJs;
        return $this;
    }

    /**
     * @return string
     */
    public function getWrapperClass(): string
    {
        return $this->wrapperClass;
    }

    /**
     * @param string $wrapperClass
     * @return $this
     */
    public function setWrapperClass(string $wrapperClass): self
    {
        $this->wrapperClass = $wrapperClass;
        return $this;
    }

    /**
     * @return $this
     */
    public function withCustomFields(): self
    {
        $customFields = [
//            'customSelect' => SelectField::class,
            'editor' => EditorField::class,
            'onOff' => OnOffField::class,
//            'onOffCheckbox' => OnOffCheckboxField::class,
//            'customRadio' => RadioField::class,
            'mediaImage' => MediaImageField::class,
            'mediaImages' => MediaImagesField::class,
            'mediaFile' => MediaFileField::class,
            'customColor' => ColorField::class,
            'time' => TimeField::class,
//            'datePicker' => DatePickerField::class,
//            'datetime' => DatetimeField::class,
            'autocomplete' => AutocompleteField::class,
            'html' => HtmlField::class,
            'repeater' => RepeaterField::class,
//            'tags' => TagField::class,
//            'multiCheckList' => MultiCheckListField::class,
        ];
//        $customFields = [
//            'customSelect' => CustomSelectField::class,
//            'editor'       => EditorField::class,
//            'onOff'        => OnOffField::class,
//            'customRadio'  => CustomRadioField::class,
//            'mediaImage'   => MediaImageField::class,
//            'mediaImages'  => MediaImagesField::class,
//            'mediaFile'    => MediaFileField::class,
//            'customColor'  => ColorField::class,
//            'time'         => TimeField::class,
//            'date'         => DateField::class,
//            'autocomplete' => AutocompleteField::class,
//            'html'         => HtmlField::class,
//            'repeater'     => RepeaterField::class,
//        ];

        foreach ($customFields as $key => $field) {
            if (!$this->formHelper->hasCustomField($key)) {
                $this->addCustomField($key, $field);
            }
        }

        return apply_filters('form_custom_fields', $this, $this->formHelper);
    }

    /**
     * @param string $name
     * @param string $class
     * @return $this|Form
     */
    public function addCustomField($name, $class)
    {
        parent::addCustomField($name, $class);

        return $this;
    }

    /**
     * @return $this
     */
    public function hasTabs(): self
    {
        $this->setFormOption('template', 'kamruldashboard::forms.form-tabs');

        return $this;
    }

    /**
     * @return int
     */
    public function hasMainFields()
    {
        if (!$this->breakFieldPoint) {
            return count($this->fields);
        }

        $mainFields = [];

        /**
         * @var FormField $field
         */
        foreach ($this->fields as $field) {
            if ($field->getName() == $this->breakFieldPoint) {
                break;
            }

            $mainFields[] = $field;
        }

        return count($mainFields);
    }

    /**
     * @return $this
     */
    public function disableFields()
    {
        parent::disableFields();

        return $this;
    }

    /**
     * @param array $options
     * @param bool $showStart
     * @param bool $showFields
     * @param bool $showEnd
     * @return string
     */
    public function renderForm(array $options = [], $showStart = true, $showFields = true, $showEnd = true): string
    {
        Assets::addScripts(['form-validation', 'are-you-sure']);

        $class = $this->getFormOption('class');
        $this->setFormOption('class', $class . ' dirty-check');

        $model = $this->getModel();

        $this->dispatchBeforeRendering();

        FormRendering::dispatch($this);

        apply_filters(BASE_FILTER_BEFORE_RENDER_FORM, $this, $model);

        if ($model->getKey()) {
            event(new BeforeEditContentEvent($this->request, $model));
        } else {
            event(new BeforeCreateContentEvent($this->request, $model));
        }
        return parent::renderForm($options, $showStart, $showFields, $showEnd);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function renderValidatorJs()
    {
        $element = null;
        if ($this->getFormOption('id')) {
            $element = '#' . $this->getFormOption('id');
        } elseif ($this->getFormOption('class')) {
            $element = '.' . $this->getFormOption('class');
        }

//        return JsValidator::formRequest($this->getValidatorClass(), $element);
    }

    /**
     * @return string
     */
    public function getValidatorClass(): string
    {
        return $this->validatorClass;
    }

    /**
     * @param string $validatorClass
     * @return $this
     */
    public function setValidatorClass($validatorClass): self
    {
        $this->validatorClass = $validatorClass;

        return $this;
    }

    /**
     * Set model to form object.
     *
     * @param mixed $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        $this->rebuildForm();

        return $this;
    }

    /**
     * Setup model for form, add namespace if needed for child forms.
     *
     * @param string $model
     * @return $this
     */
    protected function setupModel($model)
    {
        if (!$this->model) {
            $this->model = $model;
            $this->setupNamedModel();
        }

        return $this;
    }

    /**
     * Set form options.
     *
     * @param array $formOptions
     * @return $this
     */
    public function setFormOptions(array $formOptions)
    {
        parent::setFormOptions($formOptions);

        if (isset($formOptions['template'])) {
            $this->template = $formOptions['template'];
        }

        return $this;
    }
    public function add($name, $type = 'text', array $options = [], $modify = false)
    {
        if (Assets::hasVueJs()) {
            $options['attr']['v-pre'] = 1;
        }

        if ($options instanceof Arrayable) {
            $options = $options->toArray();
        }

        parent::add($name, $type, $options, $modify);

        return $this;
    }

    public function template(string $template)
    {
        $this->setFormOption('template', $template);

        return $this;
    }

    public function contentOnly()
    {
        $this->template('kamruldashboard::forms.form-content-only');

        return $this;
    }

    public function setUrl($url)
    {
        $this->setFormOption('url', $url);

        return $this;
    }

    public function onlyValidatedData(bool $onlyValidatedData = true)
    {
        $this->onlyValidatedData = $onlyValidatedData;

        return $this;
    }

    public function getRequestData(): array
    {
        $request = $this->request;

        if ($this->onlyValidatedData && $request instanceof FormRequest) {
            return $request->validated();
        }

        return $request->input();
    }

    public static function beforeSaving(callable $callback, int $priority = 100): void
    {
        if (static::class === FormAbstract::class) {
            add_action(BASE_FILTER_BEFORE_SAVE_FORM, $callback, $priority, 2);

            return;
        }

        add_action(static::getFilterPrefix() . '_before_saving', $callback, $priority, 2);
    }

    public static function afterSaving(callable $callback, int $priority = 100): void
    {
        if (static::class === FormAbstract::class) {
            add_action(BASE_FILTER_AFTER_SAVE_FORM, $callback, $priority, 2);

            return;
        }

        add_action(static::getFilterPrefix() . '_after_saving', $callback, $priority, 2);
    }

    public function save(): void
    {
        $this->saving(function (FormAbstract $form) {
            $form
                ->getModel()
                ->fill($form->getRequestData())
                ->save();
        });
    }

    public function saveOnlyValidatedData(): void
    {
        $this->onlyValidatedData()->save();
    }

    public function saving(callable $callback): void
    {
        $model = $this->getModel();
        $request = $this->request;

        if ($model instanceof DboardModel) {
            if ($model->getKey()) {
                BeforeUpdateContentEvent::dispatch($request, $model);
            } else {
                BeforeCreateContentEvent::dispatch($request, $model);
            }
        }

        $this->dispatchBeforeSaving();

        call_user_func($callback, $this);

        $this->saveMetadataFields();

        $this->dispatchAfterSaving();

        $model = $this->getModel();

        if ($model instanceof Model && $model->exists) {
            $this->fireModelEvents($model);
        }
    }

    public function fireModelEvents(Model $model): void
    {
        if ($model->wasRecentlyCreated) {
            CreatedContentEvent::dispatch('form', $this->request, $model);
        } else {
            UpdatedContentEvent::dispatch('form', $this->request, $model);
        }
    }

    protected function dispatchBeforeSaving(): void
    {
        do_action(BASE_FILTER_BEFORE_SAVE_FORM, $this);
        do_action(static::getFilterPrefix() . '_before_saving', $this);
    }

    protected function dispatchAfterSaving(): void
    {
        do_action(BASE_FILTER_AFTER_SAVE_FORM, $this);
        do_action(static::getFilterPrefix() . '_after_saving', $this);
    }

    public static function getFilterPrefix(): string
    {
        return sprintf(
            'base_form_%s',
            Str::of(static::class)->snake()->lower()->replace('\\', '')->toHtmlString()
        );
    }

    public static function getGlobalClassName(): string
    {
        return FormAbstract::class;
    }

    public static function hasGlobalExtend(): bool
    {
        return true;
    }

    public static function globalExtendFilterName(): string
    {
        return BASE_FILTER_EXTENDED_FORM;
    }

    public static function hasGlobalRendering(): bool
    {
        return true;
    }

    public static function globalBeforeRenderingFilterName(): string
    {
        return BASE_FILTER_BEFORE_RENDER_FORM;
    }

    public static function globalAfterRenderingFilterName(): string
    {
        return BASE_FILTER_AFTER_RENDER_FORM;
    }

    public static function create(array $options = [], array $data = [])
    {
        return app(FormBuilder::class)->create(static::class, $options, $data);
    }

    public static function createFromArray(array $object, array $options = [], array $data = [])
    {
        // Merge $options with 'model' => $object using array_merge
        $mergedOptions = array_merge($options, ['model' => $object]);

        // Call the create method with the merged options and data
        return static::create($mergedOptions, $data);
    }

    public static function createFromModel(DboardModel $model, array $options = [], array $data = [])
    {
        // Merge $options with 'model' => $model using array_merge
        $mergedOptions = array_merge($options, ['model' => $model]);

        // Call the create method with the merged options and data
        return static::create($mergedOptions, $data);
    }

    public function hasFiles(bool $hasFiles = true)
    {
        $this->setFormOption('files', $hasFiles);

        return $this;
    }

    public function formClass(string $class, bool $override = false)
    {
        if ($override) {
            $this->setFormOption('class', $class);

            return $this;
        }

        $this->setFormOption('class', $this->getFormOption('class') . ' ' . $class);

        return $this;
    }
}
