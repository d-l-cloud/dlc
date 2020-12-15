<?php

namespace App\Models\User;

use App\Models\News\News;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'surname',
        'middle_name',
        'male_female_other',
        'day_birth',
        'month_birth',
        'year_birth',
        'phone',
        'city',
        'country',
        'time_zone',
        'about_me',
        'profile_url',
        'avatar',
    ];
}


