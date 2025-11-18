<?php

namespace Modules\SimpleSlider\Http\Models;


use Modules\KamrulDashboard\Http\Models\DboardModel;

class SimpleSliderItem extends DboardModel
{
    protected $table = 'simple_slider_items';

    protected $fillable = [
        'title',
        'description',
        'link',
        'image',
        'order',
        'simple_slider_id',
    ];
}
