<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    use HasFactory;
    protected $fillable = [
        'city',
        'address',
        'geocode',
        'emailNotifications',
        'phone',
        'workingHours',
    ];
}
