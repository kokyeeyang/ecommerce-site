<?php
use Illuminate\Support\Facades\Route;
// use Auth;

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
// require 'admin.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Route::view('/', 'site.pages.homepage')->name('register');
Route::get('/category/{slug}', 'Site\CategoryController@show')->name('category.show');
Route::get('/product/{slug}', 'Site\ProductController@show')->name('product.show');

Route::post('/product/add/cart', 'Site\ProductController@addToCart')->name('product.add.cart');
Route::get('/cart', 'Site\CartController@getCart')->name('checkout.cart');
Route::get('/cart/item/{id}/remove', 'Site\CartController@removeItem')->name('checkout.cart.remove');
Route::get('/cart/clear', 'Site\CartController@clearCart')->name('checkout.cart.clear');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/checkout', 'Site\CheckoutController@getCheckout')->name('checkout.index');
    Route::post('/checkout/order', 'Site\CheckoutController@placeOrder')->name('checkout.place.order');
    
    Route::get('checkout/payment/complete', 'Site\CheckoutController@complete')->name('checkout.payment.complete');
    
    Route::get('account/orders', 'Site\AccountController@getOrders')->name('account.orders');
});

Route::group(['prefix'  =>  'admin'], function () {
    
    Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Admin\LoginController@login')->name('admin.login.post');
    Route::get('logout', 'Admin\LoginController@logout')->name('admin.logout');
    
    Route::group(['middleware' => ['auth:admin']], function () {
        
        Route::get('/', function () {
            return view('admin.dashboard.index');
        })->name('admin.dashboard');
        // })->name('login');
        
        // Route::get('/settings', 'Admin\SettingController@index')->name('admin.settings');
        // Route::post('/settings', 'Admin\SettingController@update')->name('admin.settings.update');
        
        Route::post('/', function () {
            return view('admin.dashboard.index');
        })->name('login');
        
        Route::get('/settings', 'Admin\SettingController@index')->name('admin.settings');
        Route::post('/settings', 'Admin\SettingController@update')->name('admin.settings.update');

        Route::group(['prefix'  =>   'categories'], function () {
            
            Route::get('/', 'Admin\CategoryController@index')->name('admin.categories.index');
            Route::get('/create', 'Admin\CategoryController@create')->name('admin.categories.create');
            Route::post('/store', 'Admin\CategoryController@store')->name('admin.categories.store');
            Route::get('/{id}/edit', 'Admin\CategoryController@edit')->name('admin.categories.edit');
            Route::post('/update', 'Admin\CategoryController@update')->name('admin.categories.update');
            Route::get('/{id}/delete', 'Admin\CategoryController@delete')->name('admin.categories.delete');
        });
        
        Route::group(['prefix'  =>   'attributes'], function () {
            
            Route::get('/', 'Admin\AttributeController@index')->name('admin.attributes.index');
            Route::get('/create', 'Admin\AttributeController@create')->name('admin.attributes.create');
            Route::post('/store', 'Admin\AttributeController@store')->name('admin.attributes.store');
            Route::get('/{id}/edit', 'Admin\AttributeController@edit')->name('admin.attributes.edit');
            Route::post('/update', 'Admin\AttributeController@update')->name('admin.attributes.update');
            Route::get('/{id}/delete', 'Admin\AttributeController@delete')->name('admin.attributes.delete');
            
            Route::post('/get-values', 'Admin\AttributeValueController@getValues');
            Route::post('/add-values', 'Admin\AttributeValueController@addValues');
            Route::post('/update-values', 'Admin\AttributeValueController@updateValues');
            Route::post('/delete-values', 'Admin\AttributeValueController@deleteValues');
        });
        
        Route::group(['prefix'  =>   'brands'], function () {
            
            Route::get('/', 'Admin\BrandController@index')->name('admin.brands.index');
            Route::get('/create', 'Admin\BrandController@create')->name('admin.brands.create');
            Route::post('/store', 'Admin\BrandController@store')->name('admin.brands.store');
            Route::get('/{id}/edit', 'Admin\BrandController@edit')->name('admin.brands.edit');
            Route::post('/update', 'Admin\BrandController@update')->name('admin.brands.update');
            Route::get('/{id}/delete', 'Admin\BrandController@delete')->name('admin.brands.delete');
        });

        Route::group(['prefix' => 'products'], function () {
            
            Route::get('/', 'Admin\ProductController@index')->name('admin.products.index');
            Route::get('/create', 'Admin\ProductController@create')->name('admin.products.create');
            Route::post('/store', 'Admin\ProductController@store')->name('admin.products.store');
            Route::get('/edit/{id}', 'Admin\ProductController@edit')->name('admin.products.edit');
            Route::post('/update', 'Admin\ProductController@update')->name('admin.products.update');
            
            Route::post('images/upload', 'Admin\ProductImageController@upload')->name('admin.products.images.upload');
            Route::get('images/{id}/delete', 'Admin\ProductImageController@delete')->name('admin.products.images.delete');
            
            Route::get('attributes/load', 'Admin\ProductAttributeController@loadAttributes');
            Route::post('attributes', 'Admin\ProductAttributeController@productAttributes');
            Route::post('attributes/values', 'Admin\ProductAttributeController@loadValues');
            Route::post('attributes/add', 'Admin\ProductAttributeController@addAttribute');
            Route::post('attributes/delete', 'Admin\ProductAttributeController@deleteAttribute');
        });

        Route::group(['prefix' => 'orders'], function () {
            Route::get('/', 'Admin\OrderController@index')->name('admin.orders.index');
            Route::get('/{order}/show', 'Admin\OrderController@show')->name('admin.orders.show');
        });
    });
});

// Auth::routes();