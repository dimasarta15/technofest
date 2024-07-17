<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes(['verify' => true]);



$locales = [
    'id',
    'en',
    '',
];

foreach ($locales as $locale) {
    if (!empty($locale)) {
        $as = "$locale.";
    } else {
        $as = "";
    }
    

    // Route::group(['prefix' => $locale], function() {
    Route::group(['prefix' => $locale, 'as' => $as], function() {
        // Authentication Routes...
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('login', 'Auth\LoginController@login');
        Route::post('logout', 'Auth\LoginController@logout')->name('logout');

        // Registration Routes...
        Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'Auth\RegisterController@register');

        // Password Reset Routes...
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

        // Confirm Password (added in v6.2)
        Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
        Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');

        // Email Verification Routes...
        Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
        Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify'); // v6.x
        /* Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify'); // v5.x */
        Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
        
        
    });
}

Route::get('kirim-email','MailController@index');
Route::group(['prefix' => 'select2', 'as' => 'select2.'], function() {
    Route::get('/', [
        'uses' => 'SelectController@select2Country',
        'as' => 'country'
    ]);
});
