<?php

namespace Modules\Location\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'state_id',
        'country_id',
        'record_id',
        'order',
        'is_default',
        'status',
    ];

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class)->withDefault();
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class)->withDefault();
    }
}
