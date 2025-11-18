<?php

namespace Modules\KamrulDashboard\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use function env;
use function session;

class SettingData extends Model
{
    use HasFactory;
    protected $guarded = [];


}
