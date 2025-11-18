<?php

namespace Modules\Admission\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\KamrulDashboard\Http\Models\User;
use Modules\Location\Http\Models\Country;
use Modules\Option\Http\Models\OptionBloodGroup;
use Modules\Option\Http\Models\OptionClass;
use Modules\Option\Http\Models\OptionGroup;
use Modules\Option\Http\Models\OptionYear;

class AdmissionSslPayment extends Model
{
    use HasFactory;
    protected $table = 'admission_ssl_payment';

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'tran_id',
        'val_id',
        'student_id',
        'amount',
        'inv_uuid',
        'payment_type',
        'status',
    ];

}
