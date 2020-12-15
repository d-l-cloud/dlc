<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteForm extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'productName',
        'questionType',
        'email',
        'phone',
        'text',
        'sendMail',
    ];

    public static function rules() {
        return [
            'name' => 'required|min:3|max:255',
            'email' => 'required',
            'phone' => 'required|max:255',
            'text' => 'max:255',
            //'image' => 'mimes:jpeg,png,bmp|max:1000',
            'g-recaptcha-response' => 'required|captcha',
        ];
    }

    public static function attributeNames() {
        return [
            'name' => 'ФИО',
            'email' => 'Email',
            'phone' => 'Телефон',
            'text' => 'Сообщение',
            'g-recaptcha-response' => 'Проверка от ботов',
            //'image' => 'Фото новости',
        ];
    }
}
