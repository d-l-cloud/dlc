<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSocialLogin extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'id_in_soc',
        'type_auth',
        'avatar',
    ];
}
