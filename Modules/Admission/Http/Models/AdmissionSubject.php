<?php

namespace Modules\Admission\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\KamrulDashboard\Http\Models\User;
use Modules\Option\Http\Models\OptionClass;

class AdmissionSubject extends Model
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
        'code',
        'photo',
        'class_id',
        'total_mark',
        'order',
        'slug',
        'status',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function class()
    {
        return $this->belongsTo(OptionClass::class, 'class_id');
    }
    public function marks()
    {
        return $this->hasMany(AdmissionMark::class, 'admission_subjects_id');
    }

    public function optionClass()
    {
        return $this->belongsTo(OptionClass::class, 'class_id');
    }
}
