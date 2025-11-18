<?php

namespace Modules\Location\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\KamrulDashboard\Http\Models\User;

class Country extends Model
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
        'nationality',
        'code',
        'order',
        'is_default',
        'status',
    ];

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function (Country $country) {
            State::where('country_id', $country->id)->delete();
            City::where('country_id', $country->id)->delete();
        });
    }
}
