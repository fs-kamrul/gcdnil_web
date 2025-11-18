<?php

use Modules\Widget\Packages\Supports\AbstractWidget;

class SidebarPhotoWidget extends AbstractWidget
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
    protected $widgetDirectory = 'sidebar-photo';

    /**
     * SidebarPhotoWidget constructor.
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function __construct()
    {
        parent::__construct([
            'name'        => __('Sidebar Photo'),
            'description' => __('Add a sidebar photo to your widget area.'),
            'post_type_id'     => null,
        ]);
    }
}
