<?php

namespace Modules\Option\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Option\Enums\OptionSetStatusEnum;
use Modules\KamrulDashboard\Casts\SafeContent;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Http\Models\User;

class OptionSet extends DboardModel
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
        'uuid',
        'name',
//        'description',
//        'short_description',
        'selected_subjects',
        'class_id',
        'subject_id',
        'group_id',
        'order',
        'slug',
        'status',
        'user_id',
    ];
    protected $casts = [
        'status' => OptionSetStatusEnum::class,
        'name' => SafeContent::class,
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->belongsTo(OptionClass::class, 'class_id');
    }
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(OptionSubject::class, 'option_set_subjects', 'set_id', 'subject_id');
    }
    public function set_subjects(): BelongsToMany
    {
        return $this->belongsToMany(OptionSubject::class, 'admission_set_subjects', 'set_id', 'subject_id');
    }

    public function set_subjects_for($admissionId)
    {
        return $this->belongsToMany(
            OptionSubject::class,
            'admission_set_subjects',
            'set_id',
            'subject_id'
        )->wherePivot('admission_id', $admissionId)->get();
    }
    public function active()
    {
        return $this->where('status', 'active');
//        return rtrim(url($this->url), '/') == rtrim(Request::url(), '/');
    }
}
