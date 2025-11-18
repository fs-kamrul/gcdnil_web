<?php

namespace Modules\Admission\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\KamrulDashboard\Http\Models\User;
use Modules\Location\Http\Models\City;
use Modules\Location\Http\Models\Country;
use Modules\Location\Http\Models\State;
use Modules\Option\Http\Models\OptionBloodGroup;
use Modules\Option\Http\Models\OptionClass;
use Modules\Option\Http\Models\OptionGender;
use Modules\Option\Http\Models\OptionGroup;
use Modules\Option\Http\Models\OptionReligion;
use Modules\Option\Http\Models\OptionSet;
use Modules\Option\Http\Models\OptionSubject;
use Modules\Option\Http\Models\OptionYear;

class Admission extends Model
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
        'slug',
        'photo',
        'father_name',
        'father_phone',
        'bl_name',
        'student_id',
        'payment_amount',
        'bl_father_name',
        'bl_mother_nane',
        'blood_group',
        'mother_nane',
        'mother_phone',
        'phone',
        'dob',
        'religion',
        'gender',
        'nationality',
        'birth_registration',
        'pre_class',
        'class',
        'ssc_group',
        'year',
        'admission_group',
        'pre_institution',
        'pre_gpa',
        'ssc_board',
        'ssc_year',
        'ssc_roll',
        'ssc_registration',
        'ssc_gpa',
        'ssc_transcript',
        'ssc_testimonial',
        'pre_address',
        'pre_postcode',
        'pre_country',
        'pre_states',
        'pre_city',
        'per_address',
        'per_postcode',
        'per_country',
        'per_states',
        'per_city',
        'loc_name',
        'loc_phone',
        'loc_relation',
        'loc_address',
        'mark',
        'loc_postcode',
        'tex_id',
        'payment_img',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function marks()
    {
        return $this->hasMany(AdmissionMark::class, 'admissions_id');
//        return $this->hasMany(AdmissionMark::class, 'admissions_id', 'admissions_id')
//            ->where('admission_subjects_id', '=', $this->admission_subjects_id);
    }

    public function averageMark()
    {
//        $totalMarks = $this->marks->sum('mark');
//        $numberOfMarks = $this->marks->count();
        $average = array();
        foreach ($this->marks as $value){
            $total_mark = $value->subject->total_mark;
            $mark = $value->mark;
            $average[] = ($mark * 100) / $total_mark;
        }
        $totalMarks = array_sum($average);
        $numberOfMarks = count($average);

//        dd($numberOfMarks);
        return $numberOfMarks > 0 ? ($totalMarks / $numberOfMarks) : 0;
    }
    public function sets()
    {
        return $this->belongsToMany(
            OptionSet::class,
            'admission_set_subjects',
            'admission_id',
            'set_id'
        )->with(['set_subjects' => function ($query) {
            $query->wherePivot('admission_id', $this->id);
        }])->distinct();
    }
    public function set_name(): BelongsToMany
    {
        return $this->belongsToMany(OptionSet::class, 'admission_set_subjects', 'admission_id', 'set_id')->distinct();
    }
    public function set_subjects(): BelongsToMany
    {
        return $this->belongsToMany(OptionSubject::class, 'admission_set_subjects', 'admission_id', 'subject_id');
    }
    public function admissionMerit()
    {
        return $this->belongsTo(AdmissionMerit::class, 'admission_merits_id');
    }
    public function classes()
    {
        return $this->belongsTo(OptionClass::class, 'class');
    }
    public function pre_classes()
    {
        return $this->belongsTo(OptionClass::class, 'pre_class');
    }
    public function years()
    {
        return $this->belongsTo(OptionYear::class, 'year');
    }
    public function ssc_years()
    {
        return $this->belongsTo(OptionYear::class, 'ssc_year');
    }
    public function admission_groups()
    {
        return $this->belongsTo(OptionGroup::class, 'admission_group');
    }
    public function ssc_groups()
    {
        return $this->belongsTo(OptionGroup::class, 'ssc_group');
    }
    public function religions()
    {
        return $this->belongsTo(OptionReligion::class, 'religion');
    }
    public function genders()
    {
        return $this->belongsTo(OptionGender::class, 'gender');
    }
    public function pre_countrys()
    {
        return $this->belongsTo(Country::class, 'pre_country');
    }
    public function per_countrys()
    {
        return $this->belongsTo(Country::class, 'per_country');
    }
    public function pre_statess()
    {
        return $this->belongsTo(State::class, 'pre_states');
    }
    public function per_statess()
    {
        return $this->belongsTo(State::class, 'per_states');
    }
    public function pre_citys()
    {
        return $this->belongsTo(City::class, 'pre_city');
    }
    public function per_citys()
    {
        return $this->belongsTo(City::class, 'per_city');
    }
    public function blood_groups()
    {
        return $this->belongsTo(OptionBloodGroup::class, 'blood_group');
    }
    public function nationalities()
    {
        return $this->belongsTo(Country::class, 'nationality');
    }
}
