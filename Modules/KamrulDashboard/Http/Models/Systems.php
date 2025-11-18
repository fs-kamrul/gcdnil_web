<?php

namespace Modules\KamrulDashboard\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Systems extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Return the value of the property
     *
     * @param $key string
     * @return mixed
     */
    public static function getProperty($key)
    {
        $row = Systems::where('key', $key)
            ->first();

        if (isset($row->value)) {
            return $row->value;
        } else {
            return null;
        }
    }

    /**
     * Return the value of the multiple properties
     *
     * @param $keys array
     * @return array
     */
    public static function getProperties($keys, $pluck = false)
    {
        if ($pluck == true) {
            return Systems::whereIn('key', $keys)
                ->pluck('value', 'key');
        } else {
            return Systems::whereIn('key', $keys)
                ->get()
                ->toArray();
        }
    }

    /**
     * Return the system default currency details
     *
     * @param void
     * @return object
     */
    public static function getCurrency()
    {
        $c_id = Systems::where('key', 'app_currency_id')
            ->first()
            ->value;

        $currency = Currency::find($c_id);

        return $currency;
    }

    /**
     * Set the property
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    public static function setProperty($key, $value)
    {
        Systems::where('key', $key)
            ->update(['value' => $value]);
    }

    /**
     * Remove the specified property
     *
     * @param $key
     * @return void
     */
    public static function removeProperty($key)
    {
        Systems::where('key', $key)
            ->delete();
    }

    /**
     * Add a new property, if exist update the value
     *
     * @param $key
     * @param $value
     * @return void
     */
    public static function addProperty($key, $value)
    {
        Systems::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
