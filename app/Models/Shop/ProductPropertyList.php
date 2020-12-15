<?php

namespace App\Models\Shop;

use App\Models\User\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPropertyList extends Model
{
    use HasFactory;
    protected $fillable = ['propertyId','productId ','user_id '];

    public function user() {
        return $this->belongsTo(Profile::class, 'user_id');
    }
    public function propertyName() {
        return $this->belongsTo(ProductProperty::class, 'propertyId')->orderBy('name');
    }

}
