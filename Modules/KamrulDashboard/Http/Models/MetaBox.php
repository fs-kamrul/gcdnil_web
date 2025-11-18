<?php

namespace Modules\KamrulDashboard\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MetaBox extends DboardModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'meta_boxes';

    /**
     * @var array
     */
    protected $casts = [
        'meta_value' => 'json',
    ];

    /**
     * @return BelongsTo
     */
    public function reference(): BelongsTo
    {
        return $this->morphTo();
    }
}
