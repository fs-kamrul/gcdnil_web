<?php

namespace Modules\Faq\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\KamrulDashboard\Casts\SafeContent;
use Modules\KamrulDashboard\Http\Models\User;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;

class FaqCategory extends Model
{
    protected $table = 'faq_categories';
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
        'order',
        'status',
    ];

    protected $casts = [
        'status' => DboardStatus::class,
        'name' => SafeContent::class,
    ];

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class, 'category_id');
    }
}
