<?php

namespace App\Http\Controllers;

use App\Models\Shop\ProductCategory;
use Illuminate\Http\Request;
use App\Models\Shop\ProductList;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class SearchController extends Controller
{
    public function query(Request $request)
    {

        $query=strip_tags(htmlspecialchars($request->route('query')));
        $products = ProductList::search($query)->paginate();
        //$products = ProductList::search($query)->within('product_lists')->where('variable',0)->where('variable',1)->paginate(12);
        $productCategory = ProductCategory::get();
        $countArray = 0;
        foreach ($products as $product) {
            $countArray ++;
            $getSubCategoryUrl = ProductCategory::where('id', '=', $product['productCategoryId'])->first();
            $getCategoryUrl = ProductCategory::where('id', '=', $getSubCategoryUrl->parent_id)->first();
            $productItem[$countArray]['article'] = $product['article'];
            $productItem[$countArray]['link'] = '/katalog/'.$getCategoryUrl->slug.'/'.$getSubCategoryUrl->slug.'/'.$product['article'].'/';
            $productItem[$countArray]['name'] = $product['name'];
            $productItem[$countArray]['images'] = $product['images'];
            $productItem[$countArray]['price'] = number_format($product['price'], 0, ',', ' ');
            $productItem[$countArray]['vendor'] = $product['vendor']['name'];
        }
        $productCategoryArray= $productCategory->toArray();
        $page['title'] = urldecode($query);
        return view('search.searchList')
            ->with('page', $page)
            ->with('productCategory', $productCategoryArray)
            ->with('query', $products);
    }

    public function add()
    {
        // this post should be indexed at Algolia right away!
        $post = new Post;
        $post->setAttribute('name', 'Another Post');
        $post->setAttribute('user_id', '1');
        $post->save();
    }

    public function delete()
    {
        // this post should be removed from the index at Algolia right away!
        $post = Post::find(1);
        $post->delete();
    }


    public function searchNames(Request $request) {
        if ($request->searchText) {
            $products = ProductList::search($request->searchText)->where("isHidden",'=', 0)->paginate(5);
            $checkTotal = collect($products)->get('total');
            if ($checkTotal!=0) {
                $countArray = 0;
                foreach ($products as $product) {
                    $countArray ++;

                    $getSubCategoryUrl = ProductCategory::where('id', '=', $product['productCategoryId'])->first();
                    $productItem[$countArray]['article'] = $product['article'];
                    if ($getSubCategoryUrl->parent_id!=0) {
                        $getCategoryUrl = ProductCategory::where('id', '=', $getSubCategoryUrl->parent_id)->first();
                        $productItem[$countArray]['link'] = '/katalog/' . $getCategoryUrl->slug . '/' . $getSubCategoryUrl->slug . '/' . $product['article'] . '/';
                    }else {
                        $productItem[$countArray]['link'] = '/katalog/' . $getSubCategoryUrl->slug . '/' . $product['article'] . '/';
                    }
                    $productItem[$countArray]['name'] = $product['name'];
                    if ($product['images']) {
                    $productItem[$countArray]['images'] = $product['images'];
                        }else {
                        $productItem[$countArray]['images'] = '/templates/img/foto_not_found.jpg';
                    }
                    $productItem[$countArray]['price'] = number_format($product['price'], 0, ',', ' ');
                    $productItem[$countArray]['vendor'] = $product['vendor']['name'];
                }

                $searchQuery=urlencode($request->searchText);
                $returnData = ['status' => 'ok', 'data' => $productItem, 'searchQuery' => $searchQuery];
                return response()->json($returnData, 200);
            }
            $returnData = ['status' => 'error'];
            return response()->json($returnData, 422);
        }
    }
}
