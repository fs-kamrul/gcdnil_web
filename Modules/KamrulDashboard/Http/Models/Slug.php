<?php

namespace Modules\KamrulDashboard\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Slug extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'slugs';
    use HasFactory;
    protected $guarded = [];

    /**
     * @var array
     */
    protected $fillable = [
        'key',
        'reference_type',
        'reference_id',
        'prefix',
    ];

    /**
     * @return BelongsTo
     */
    public function reference(): BelongsTo
    {
        return $this->morphTo();
    }
    public function createSlug($name)
    {
        $slug = Str::slug($name);
        $index = 1;
        $baseSlug = $slug;
        while ($this::where('key', $slug)->count() > 0) {
            $slug = $baseSlug . '-' . $index++;
        }
        if (empty($slug)) {
            $slug = time();
        }
        return $slug;
    }
}
