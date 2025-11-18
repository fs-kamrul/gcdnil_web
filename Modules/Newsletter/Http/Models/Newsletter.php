<?php

namespace Modules\Newsletter\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Ecommerce\Http\Models\EcommerceProduct;
use Modules\KamrulDashboard\Casts\SafeContent;
use Modules\KamrulDashboard\Http\Models\User;
use Modules\Newsletter\Http\packages\NewsletterStatus;

class Newsletter extends Model
{
//    use HasFactory;
    protected $guarded = [];

    protected $table = 'newsletters';

    protected $fillable = [
        'email',
        'name',
        'product_id',
        'status',
    ];

    protected $casts = [
        'name' => SafeContent::class,
        'status' => NewsletterStatus::class,
    ];
    public function product()
    {
        if(is_module_active('Ecommerce')) {
            return $this->belongsTo(EcommerceProduct::class);
        }else{
            return 0;
        }
    }
    public function getProductNameAttribute()
    {
        if(is_module_active('Ecommerce') && $this->product_id != 0) {
            return $this->product->name;
        }else{
            return '&mdash;';
        }
    }
}
