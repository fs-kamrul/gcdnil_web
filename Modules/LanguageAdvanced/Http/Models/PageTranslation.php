<?php

namespace Modules\LanguageAdvanced\Http\Models;

use Modules\KamrulDashboard\Http\Models\DboardModel;

class PageTranslation extends DboardModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pages_translations';

    /**
     * @var array
     */
    protected $fillable = [
        'lang_code',
        'pages_id',
        'name',
        'description',
        'content',
        'short_description',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
}
