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
    return 404;
});

Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin'], function () {
        Route::get('logout', 'Admin\Auth\LogoutController@logout');

        Route::get('dashboard', 'Admin\DashboardController@show');

        Route::get('user', 'Admin\User\ListController@show');
        Route::get('user/data', 'Admin\User\ListController@data');
        Route::get('user/{id}', 'Admin\User\DetailController@show');
//        Route::post('user/edit');

        Route::get('book', 'Admin\Book\ListController@show');
        Route::get('book/data', 'Admin\Book\ListController@data');
        Route::get('book/search', 'Admin\Book\SearchController@show');
        Route::post('book/search', 'Admin\Book\SearchController@search');
        Route::get('book/add', 'Admin\Book\AddController@show');
        Route::post('book/add', 'Admin\Book\AddController@add');
        Route::get('book/{id}', 'Admin\Book\DetailController@show');
        Route::post('book/edit', 'Admin\Book\DetailController@edit');

        Route::get('borrow', 'Admin\Borrow\ListController@show');
        Route::get('borrow/data', 'Admin\Borrow\ListController@data');
//        Route::get('borrow/{id}');

//        Route::get('setting');
    });

    Route::get('login', 'Admin\Auth\LoginController@show');
    Route::post('login', 'Admin\Auth\LoginController@login');

    Route::get('/', 'Admin\IndexController@show');
});


//Route::group(['prefix' => 'm'], function () {
//    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
//    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//});

//Route::post('login', 'Auth\LoginController@login');
//Route::post('logout', 'Auth\LoginController@logout')->name('logout');
//
//Route::post('register', 'Auth\RegisterController@register');
//
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset');
//
//Route::get('/home', 'HomeController@index')->name('home');
