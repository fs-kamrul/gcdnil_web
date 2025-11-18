<?php

namespace Modules\ContactForm\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\ContactForm\Enums\ContactStatus;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Modules\KamrulDashboard\Packages\Supports\Avatar;

class ContactForm extends DboardModel
{
    protected $table = 'contact_forms';
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'subject',
        'content',
        'organization',
        'contact_data',
        'contact_time',
        'status',
    ];

    protected $casts = [
        'status' => ContactStatus::class,
    ];

    public function replies(): HasMany
    {
        return $this->hasMany(ContactFormReplie::class);
    }

    protected function avatarUrl(): Attribute
    {
        return new Attribute(function () {
            try {
                return (new Avatar())->create($this->name)->toBase64();
            } catch (\Exception $exception) {
                return getDefaultImage();
            }
        });
    }
}
