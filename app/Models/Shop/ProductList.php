<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
//use Spatie\Searchable\Searchable;
//use Spatie\Searchable\SearchResult;

class ProductList extends Model
{
    use Searchable;
    use HasFactory;
    protected $fillable = [
        'article',
        'parentArticle',
        'vendorCode',
        'productCategoryId',
        'keywords',
        'description',
        'name',
        'slug',
        'text',
        'images',
        'isHidden',
        'new',
        'sale',
        'views',
        'user_id',
        'source',
        'price',
        'variable'];

    public function category() {
        return $this->belongsTo(ProductCategory::class, 'productCategoryId');
    }
    public function vendor() {
        return $this->belongsTo(ProductVendor::class, 'vendorCode');
    }
    public static function rules() {
        return [
            'article' => 'required|numeric|unique:product_lists,article',
            'name' => 'required',
            'slug' => 'required',
            'vendorCode' => 'required|numeric',
            'price' => 'required|numeric',
            'productCategoryId' => 'required|numeric',
            'isHidden' => 'boolean',
            'new' => 'boolean',
            'sale' => 'boolean',
        ];
    }
    public static function rulesEdit($id) {
        return [
            'article' => "required|numeric|unique:product_lists,article,$id",
            'name' => 'required',
            'slug' => 'required',
            'vendorCode' => 'required|numeric',
            'price' => 'required|numeric',
            'productCategoryId' => 'required|numeric',
            'isHidden' => 'boolean',
            'new' => 'boolean',
            'sale' => 'boolean',
        ];
    }

    public static function attributeNames() {
        return [
            'article' => 'Артикул',
            'parentArticle'  => 'Родительский артикул',
            'name' => 'Название товара',
            'slug' => 'ЧПУ товара',
            'vendorCode' => 'Производитель',
            'price' => 'Стоимость',
            'productCategoryId' => 'Категория',
            'isHidden' => 'Скрыть товар',
            'new' => 'Новинка',
            'sale' => 'Распродажа',
        ];
    }

    public function toSearchableArray()
    {
        //$array = $this->toArray();
        //return array('id'=>'','article' => $array['article'],'name' => $array['name']);
        //return $array;
        /*$count=1;
        $productData = $this->toArray();
        $productData['id'] = $count++;
        $productData['article'] = $this->article;
        $productData['name'] = $this->name;
        return $productData;*/
        return [
            'id'        => $this->id,
            'article'   => $this->article,
            'name'      => $this->name,
        ];

    }

    public function getSearchResult(): SearchResult
    {
        $url = route('searchQuery', $this->id);

        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }

}
