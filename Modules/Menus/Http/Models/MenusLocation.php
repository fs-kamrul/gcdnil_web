<?php

namespace Modules\Menus\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\KamrulDashboard\Http\Models\DboardModel;

class MenusLocation extends DboardModel
{
    use HasFactory;
    protected $guarded = [];

    /**
     * @var array
     */
    protected $fillable = [
        'menus_id',
        'location',
    ];

    /**
     * @return BelongsTo
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menus::class, 'menus_id')->withDefault();
    }
}
