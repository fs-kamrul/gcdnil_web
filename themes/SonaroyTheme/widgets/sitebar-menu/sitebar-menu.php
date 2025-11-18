<?php

use Modules\Widget\Packages\Supports\AbstractWidget;

class SitebarMenuWidget extends AbstractWidget
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
    protected $widgetDirectory = 'sitebar-menu';

    /**
     * CustomMenuWidget constructor.
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function __construct()
    {
        parent::__construct([
            'name'        => __('Sitebar Menu'),
            'description' => __('Add a custom menu to your widget area.'),
            'menu_id'     => null,
        ]);
    }
}
