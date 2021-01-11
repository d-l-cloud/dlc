<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminIndexController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminNewsCategoryController;
use UniSharp\LaravelFilemanager\Lfm;
use App\Http\Controllers\Admin\AdminStaticPage;
use App\Http\Controllers\Admin\Settings\AdminSiteMenuController;
use App\Http\Controllers\Admin\Shop\AProductCategory;
use App\Http\Controllers\SearchController;
use App\Models\Shop\ProductCategory;
use App\Http\Controllers\Shop\ShowProductController;
use App\Http\Controllers\Shop\ShowCategoryController;
use App\Http\Controllers\Admin\Shop\AProductManufacturerController;
use App\Http\Controllers\Admin\Shop\AProductPropertyController;
use App\Http\Controllers\Admin\Settings\ASiteSettingsController;
use App\Http\Controllers\Admin\Shop\AProductListController;
use App\Http\Controllers\News\ShowNewsController;
use App\Http\Controllers\Manufacturer\ShowManufacturerController;
use App\Http\Controllers\SiteFormRecaptcha;
use App\Http\Controllers\Site\StaticPagesController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//авторизация через соцсети
Route::get('social-login/{provider}', [LoginController::class, 'socialLogin'])->name('socLogin');
Route::get('social-callback/{provider}', [LoginController::class, 'socialCallBack'])->name('socResponse');


//Админка
Route::name('admin.')
    ->prefix('cpa')
    ->namespace('Admin')
    ->middleware('auth','role:admin')
    ->group(
        function () {
            Route::get('/', [AdminIndexController::class, 'index'])->name('index');
            Route::name('shop.')
                ->prefix('shop')
                ->namespace('Admin')
                ->middleware('auth','role:admin')
                ->group(
                    function () {
                        Route::get('/product-list', [AdminIndexController::class, 'index'])->name('product-list');
                        Route::get('/product-properties', [AdminIndexController::class, 'index'])->name('product-properties');
                        //Route::post('/toggle', [IndexController::class, 'ajax'])->name('toggle');
                        //Route::get('/parser', [ParserController::class, 'index'])->name('parser');

                    }
                );
            Route::name('settings.')
                ->prefix('settings')
                ->namespace('Admin')
                ->middleware('auth','role:admin')
                ->group(
                    function () {
                        Route::get('/design-settings', [AdminIndexController::class, 'index'])->name('design');
                        Route::get('/mail-settings', [AdminIndexController::class, 'index'])->name('mail');
                        Route::get('/site-settings', [ASiteSettingsController::class, 'index'])->name('site');
                        Route::put('/site-settings', [ASiteSettingsController::class, 'edit'])->name('site');
                        Route::get('/menu-settings', [AdminSiteMenuController::class, 'index'])->name('menu');
                        Route::get('/menu-add-settings', [AdminSiteMenuController::class, 'create'])->name('menuAdd');
                        Route::post('/menu-save-settings', [AdminSiteMenuController::class, 'store'])->name('menuSave');
                        Route::post('/menu-delete-ajax', [AdminSiteMenuController::class, 'deleteMenu'])->name('menu-delete-ajax');
                        Route::post('/menu-sorting-ajax', [AdminSiteMenuController::class, 'sortingMenu'])->name('menu-sorting-ajax');
                        //Route::post('/toggle', [IndexController::class, 'ajax'])->name('toggle');
                        //Route::get('/parser', [ParserController::class, 'index'])->name('parser');

                    }
                );

            Route::get('/payment', [AdminIndexController::class, 'index'])->name('payment');
            Route::get('/user', [AdminIndexController::class, 'index'])->name('user');
            Route::get('/clear-all', function() {
                Artisan::call('cache:clear');
                Artisan::call('view:clear');
                Artisan::call('config:clear');
                Artisan::call('route:clear');
                return redirect()->route('admin.index');
            })->name('clear-all')->middleware('role:super-admin');
            Route::get('/scout-flush', function() {
                Artisan::call('scout:flush "App\Models\Shop\ProductList"');
                return redirect()->route('admin.index');
            })->name('scout-flush')->middleware('role:super-admin');

        }
    );
Route::name('admin.')
    ->prefix('cpa/news')
    ->middleware('auth','role:admin')
    ->group(
        function () {
            Route::resource('/news-list', AdminNewsController::class)->except('show');
            Route::resource('/news-categories', AdminNewsCategoryController::class)->except('show');
            Route::get('/news-hidden-ajax/{id}', [AdminNewsController::class, 'getNewsById'])->name('news-hidden-ajax');
            Route::post('/news-hidden-ajax-update', [AdminNewsController::class, 'updateHiddenStatus'])->name('news-hidden-ajax-update');
            Route::get('/news-category-ajax-slug', [AdminNewsCategoryController::class, 'updateCategorySlug'])->name('news-category-ajax-slug');
            //Route::post('/toggle', [IndexController::class, 'ajax'])->name('toggle');
            //Route::get('/parser', [ParserController::class, 'index'])->name('parser');

        }
    );

Route::name('admin.')
    ->prefix('cpa/shop')
    ->middleware('auth','role:admin')
    ->group(
        function () {
            Route::resource('/product-categories', AProductCategory::class)->except('show');
            Route::resource('/product-manufacturer', AProductManufacturerController::class)->except('show');
            Route::post('/product-manufacturer-hidden-ajax-update', [AProductManufacturerController::class, 'updateHiddenStatus'])->name('product-manufacturer-hidden-ajax-update');
            Route::resource('/product-properties', AProductPropertyController::class)->except('show');
            Route::resource('/product-list', AProductListController::class)->except('show');
            Route::post('/product-list-hidden-ajax-update', [AProductListController::class, 'updateHiddenStatus'])->name('product-list-hidden-ajax-update');
            Route::put('/product-list-photo/{id}', [AProductListController::class,'savePhoto']);
            Route::put('/product-list-prop/{id}', [AProductListController::class,'saveProp']);
            Route::get('/product-properties-ajax-similar', [AProductPropertyController::class, 'updatePropertiesSimilar'])->name('product-properties-ajax-similar');
            Route::get('/product-category-ajax-similar', [AProductCategory::class, 'updateCategoriesSimilar'])->name('product-category-ajax-similar');

            //Route::post('/toggle', [IndexController::class, 'ajax'])->name('toggle');
            //Route::get('/parser', [ParserController::class, 'index'])->name('parser');

        }
    );

Route::name('admin.')
    ->prefix('cpa/static-pages')
    ->middleware('auth','role:admin')
    ->group(
        function () {
            Route::resource('/list', AdminStaticPage::class)->except('show');
            Route::post('/list-hidden-ajax-update', [AdminStaticPage::class, 'updateHiddenStatus'])->name('list-hidden-ajax-update');
        }
    );


//Настройки пользователя
Route::name('user.')
    ->prefix('user')
    ->middleware('auth')
    ->group(
        function () {
            Route::resource('profile', ProfileController::class)->except('show');
            Route::put('profileAjaxEdit', [ProfileController::class, 'profileAjaxEdit'])->name('profileAjaxEdit');
            //Route::get('/parser', [ParserController::class, 'index'])->name('parser');

        }
    );

Route::name('katalog.')
    ->prefix('katalog')
    ->group(
        function () {
            Route::get('/', [ShowCategoryController::class, 'index'])->name('katalogMain');
            Route::get('{category}', [ShowCategoryController::class, 'index'])->name('katalogCategory');
            Route::get('{category}/{subCategory}', [ShowCategoryController::class, 'index'])->name('katalogSubCategory');
            Route::get('{category}/{subCategory}/{productArticle}', [ShowProductController::class, 'index'])->where('productArticle', '[0-9]+')->name('katalogProductArticle');
}
    );
Route::name('filter.')
    ->prefix('filter')
    ->group(
    function () {
        Route::post('/set-filter-values', [ShowCategoryController::class, 'setFilterValues'])->name('setFilterValues');
        Route::get('/del-filter-values/{filterNames}', [ShowCategoryController::class, 'delFilterValues'])->name('delFilterValues');
    }
);
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});

Route::post('search-ajax', [SearchController::class, 'searchNames'])->name('searchAjax');
Route::get('search/{query}', [SearchController::class, 'query'])->name('searchQuery');
Route::get('searchUrl/{query}', [ProductCategory::class, 'searchUrl'])->where('query', '[0-9]+')->name('searchUrl');

Route::get('/news/{id}', [ShowNewsController::class, 'show'])->name('newsItem');
Route::get('/news', [ShowNewsController::class, 'index'])->name('newsList');

Route::get('/manufacturer/{id}', [ShowManufacturerController::class, 'show'])->name('manufacturerItem');
Route::get('/manufacturer', [ShowManufacturerController::class, 'index'])->name('manufacturerList');

Route::get('siteform/{productName}/{questionType}', [SiteFormRecaptcha::class, 'index'])->name('siteForm');
Route::post('validate-site-form', [SiteFormRecaptcha::class, 'store'])->name('validateSiteForm');

Route::get('/pages/{pagesName}/', [StaticPagesController::class, 'index'])->name('pagesName');
Auth::routes();


/*Route::group(['middleware' => 'role:web-developer,manage-users'], function() {
    Route::get('/tt1', function() {
        return 'Добро пожаловать, Веб-разработчик';
    });
});*/
