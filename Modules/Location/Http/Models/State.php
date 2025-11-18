<?php

namespace Modules\Location\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\KamrulDashboard\Http\Models\User;

class State extends Model
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
        'abbreviation',
        'country_id',
        'order',
        'is_default',
        'status',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class)->withDefault();
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function (State $state) {
            City::where('state_id', $state->id)->delete();
        });
    }
}
