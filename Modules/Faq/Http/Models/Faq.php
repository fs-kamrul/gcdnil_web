<?php

namespace Modules\Faq\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\KamrulDashboard\Casts\SafeContent;
use Modules\KamrulDashboard\Http\Models\User;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;

class Faq extends Model
{
    protected $table = 'faqs';
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
        'question',
        'answer',
        'category_id',
        'status',
    ];
    protected $casts = [
        'status' => DboardStatus::class,
        'question' => SafeContent::class,
        'answer' => SafeContent::class,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(FaqCategory::class, 'category_id')->withDefault();
    }
}
