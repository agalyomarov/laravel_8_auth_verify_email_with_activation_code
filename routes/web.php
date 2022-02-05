<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::get('/', 'HomeController@main')->name('home');
Route::get('/register', 'RegisterController@show')->name('register.show');
Route::post('/register', 'RegisterController@store')->name('register.store');
Route::post('/logout', 'LogoutController')->name('logout');
Route::get('/login', 'LoginController@show')->name('login');
Route::post('/login', 'LoginController@authenticate')->name('login.authenticate');

Route::group(['namespace' => 'Profile', 'prefix' => 'profile', 'middleware' => ['auth', 'verified']], function () {
   Route::get('/', 'UserController@index')->name('profile.index');
   Route::patch('/name', 'UserController@nameUpdate')->name('profile.name.update');
   Route::patch('/email', 'UserController@emailUpdate')->name('profile.email.update');
   Route::patch('/password', 'UserController@passwordUpdate')->name('profile.password.update');
});




Route::get('/email/verify', 'VerifyEmailController@notice')->middleware('auth')->name('verification.notice');

Route::post('/email/verify', 'VerifyEmailController@verify')->middleware(['auth'])->name('verification.verify');

Route::post('/email/verification-notification', 'VerifyEmailController@send')->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/email/verify/new', 'VerifyEmailController@noticeNew')->middleware('auth')->name('verification.notice.new');

Route::get('/forgot-password', 'PasswordController@request')->middleware('guest')->name('password.request');

Route::post('/forgot-password', 'PasswordController@email')->middleware('guest')->name('password.email');

Route::get('/reset-password', 'PasswordController@reset')->middleware('guest')->name('password.reset');

Route::post('/reset-password', 'PasswordController@update')->middleware('guest')->name('password.update');