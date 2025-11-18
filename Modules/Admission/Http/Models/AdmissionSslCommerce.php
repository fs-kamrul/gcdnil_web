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

class AdmissionSslCommerce extends Model
{
    use HasFactory;
    protected $table = 'admission_ssl_commerces';

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
        'student_id',
        'status',
        'tran_date',
        'tran_id',
        'message',
        'val_id',
        'store_amount',
        'currency',
        'bank_tran_id',
        'card_type',
        'card_no',
        'card_issuer',
        'card_brand',
        'card_issuer_country',
        'card_issuer_country_code',
        'currency_type',
        'currency_amount',
        'currency_rate',
        'base_fair',
        'emi_instalment',
        'emi_amount',
        'emi_description',
        'emi_issuer',
        'risk_title',
        'risk_level',
        'discount_percentage',
        'discount_remarks',
        'validated_on',
        'inv_uuid',
    ];
}
