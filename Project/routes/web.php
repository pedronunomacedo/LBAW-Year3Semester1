
<?php

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\TestController;

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
// Home
Route::get('/', 'ProductsController@showHighlights');

// Cards
Route::get('cards', 'CardController@list');
Route::get('cards/{id}', 'CardController@show');

// API
Route::put('api/cards', 'CardController@create');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Profile
Route::get('profile', 'Auth\LoginController@login');
Route::get('profile/{id}', 'UserController@showProfile')->name('profile')->where('id','[0-9]+');
Route::post('adminUpdateUserProfile/saveChanges/{id}', 'UserController@updateProfileData')->name('saveUserProfile')->where('id','[0-9]+');
Route::post('adminUpdateUserProfile/savePassword/{id}', 'UserController@updateUserPassword')->name('saveUserPassword')->where('id','[0-9]+');
Route::post('/address/deleteAddress', 'UserController@deleteAddress');
Route::post('/address/addAddress', 'UserController@addAddress');
Route::post('/profile/deleteAccount', 'UserController@deleteAccount');

// Manage Users (admin)
Route::get('adminManageUsers', 'UserController@showAllUsers');
Route::post('adminManageUsers/delete', 'UserController@destroy');
Route::get('adminManageProducts', 'ProductsController@showAllProducts');
Route::post('adminManageProducts/delete', 'ProductsController@destroy')->name('adminManageProducts');
Route::post('adminManageProducts/saveChanges', 'ProductsController@updateProduct')->name('adminManageUpdateProducts');
Route::post('adminManageProducts/addProduct', 'ProductsController@addProduct')->name('adminManageProducts.addProduct');
Route::get('adminManageOrders', 'AdminController@showAllOrders');
Route::post('adminManageOrders/saveChanges', 'AdminController@saveOrderInfo')->name('adminManageUpdateOrders');
Route::get('adminManageFAQs', 'AdminController@showAllFAQs');
Route::post('adminManageFAQS/saveChanges', 'AdminController@updateFAQ')->name('adminManageUpdateFAQS');
Route::post('adminManageFAQS/delete', 'AdminController@destroyFAQ')->name('adminDeleteFAQS');
Route::post('adminManageFAQS/addFAQ', 'AdminController@addFAQ')->name('adminAddFAQ');

// Wislist
Route::get('wishlist', 'WishlistController@showWishlist');
Route::post('wishlist/addToWishlist', 'WishlistController@addWishlistProduct') -> name('addToWishlist');
Route::post('wishlist/removeFromWishlist', 'WishlistController@removeWishlistProduct') -> name('removeFromWishlist');

// ShopCart
Route::get('shopcart', 'ShopCartController@showShopcart');
Route::post('shopcart/addToShopCart', 'ShopCartController@addShopCartProduct') -> name('addToShopCart');
Route::post('shopcart/removeFromShopCart', 'ShopCartController@removeShopCartProduct') -> name('removeFromShopCart');
Route::put('shopcart', 'ShopCartController@updateProductShopCart');

//Checkout
Route::get('checkout', 'ShopCartController@showCheckout');

// Order
Route::get('orders', 'OrdersController@showOrders');
Route::get('orders/{order_id}', 'OrdersController@showOrder')->name('order');
Route::post('orders/addToOrders', 'OrdersController@addOrdersProduct') -> name('addToOrders');
Route::post('orders/removeFromOrders', 'OrdersController@removeOrdersProduct') -> name('removeFromOrders');

// Product
Route::get('product/{product_id}', 'ProductsController@showProduct')->name('product');

// User search
Route::get('search','UserController@searchUsers')->name('search_users');

// Product search
Route::get('search/products','ProductsController@searchProducts')->name('search_products');
Route::get('search/orders','OrdersController@searchOrders')->name('search_orders');
Route::post('search/adminManageProducts/delete', 'ProductsController@destroy')->name('search.adminManageProducts');
Route::get('mainPageSearch/products','ProductsController@searchMainPageProducts');

// Sign-in and Sign-up with google account
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleController::class, 'handle']);

// Product Category
Route::get('productCategory/{category}', 'ProductsController@showCategoryProducts')->name('category_page');

// Users features
Route::post('/review/addReview', 'ReviewController@addReview')->name('newReview');
Route::post('/review/deleteReview', 'ReviewController@destroy');
Route::post('/review/updateReview', 'ReviewController@updateReview');

// Email feature
Route::get('/send-email/{id}', [TestController::class, 'sendEmail'])->where('id','[0-9]+');

// FAQs
Route::get('/faqs', 'FaqController@showFaqs');

// About us
Route::get('/about', 'AboutController@showAbout');

// Contact us
Route::get('/contactUs', 'ContactUsController@showContactUs');