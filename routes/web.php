<?php

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

Route::get('/', function () {
    return view('welcome');
});

// generate all the routes required for user authentication, register, login, password reset etc.

Auth::routes();
// prevent registration, this needs to be after Auth::routes()
/*Route::redirect('register', '/home', 301);*/

Route::get('/home', 'HomeController@index')->name('home');


//PUBLIC SITE
// Pages
// Home Page
Route::get('/', 'PageController@getIndex')->name('index');
// About Page
Route::get('pages/about', 'PageController@getAbout')->name('about');
// Contact Page
Route::get('pages/contact', 'PageController@getContact')->name('contact.show');
Route::post('pages/contact', 'PageController@postContact')->name('contact');
// karmische Astrologie
Route::get('pages/karmische-astrologie', 'PageController@getKarmischeAstrologie')->name('karmische-astrologie');
// Astrologische Psychologie
Route::get('pages/astrologische-psychologie', 'PageController@getAstrologischePsychologie')->name('astrologische-psychologie');
// AstroMedizin
Route::get('pages/astromedizin', 'PageController@getAstroMedizin')->name('astromedizin');
// Presse
Route::get('pages/press', 'PageController@getPress')->name('press');


// Shop
Route::get('pages/shop/index', 'ShopController@getIndex')->name('shop.index');
Route::get('pages/shop/{id}/show', 'ShopController@show')->name('shop.show');
Route::get('pages/shop/addToCart/{id}', 'ShopController@getAddToCart')->name('shop.addToCart');
Route::get('pages/shop/shopping-cart', 'ShopController@getCart')->name('shop.shoppingCart');
Route::get('pages/reduce/{id}', 'ShopController@getReduceByOne')->name('shop.reduceByOne');
Route::get('pages/remove/{id}', 'ShopController@getRemoveItem')->name('shop.remove');
// route for astrological Counsultation
Route::get('pages/consultation/index', 'ConsultationController@getIndex')->name('consultation.index');


// PayPal
// route for processing payment
Route::post('paypal', 'PaymentController@payWithpaypal');
// route for check status of the payment
Route::get('status', 'PaymentController@getPaymentStatus');


// prevent vue routes issue when typing directly route in browser. THIS SHOULD BE PLACING AT THR BOTTOM of routes/web.php file.
/*Route::get('{any}', function () { return view('adminpanel'); })->where('any','.*');*/
Route::get('{path}', 'HomeController@index')->where('path', '([A-z\/_.\d-]+)?');
