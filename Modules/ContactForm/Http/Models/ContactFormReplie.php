<?php

namespace Modules\ContactForm\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\KamrulDashboard\Http\Models\DboardModel;

class ContactFormReplie extends DboardModel
{
    protected $table = 'contact_form_replies';
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'message',
        'contact_form_id',
    ];

}
