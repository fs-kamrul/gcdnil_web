<?php

namespace Modules\Widget\Widgets;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Modules\Widget\Packages\Supports\AbstractWidget;

class Text extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * @var string
     */
    protected $frontendTemplate = 'widget::widgets.text.frontend';

    /**
     * @var string
     */
    protected $backendTemplate = 'widget::widgets.text.backend';

    /**
     * @var bool
     */
    protected $isCore = true;

    /**
     * Text constructor.
     *
     * @throws FileNotFoundException
     */
    public function __construct()
    {
        parent::__construct([
            'name'        => trans('widget::lang.widget_text'),
            'description' => trans('widget::lang.widget_text_description'),
            'content'     => null,
        ]);
    }
}
