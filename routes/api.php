<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'App\Api\V1\Controllers'], function ($api) {
    $api->group(['prefix' => 'v1'], function ($api) {
        $api->post('auth/authenticate', 'Auth\AuthenticateController@authenticate');
        $api->post('auth/token', 'Auth\AuthenticateController@checkToken');
        $api->post('auth/initialize', 'Auth\InitializeController@initialize');
        $api->post('auth/initialize/code', 'Auth\InitializeController@sendSmsCode');
//        $api->post('auth/reset', 'Auth\ResetController@reset');

        $api->get('book/list', 'Book\ListController@getList');

        $api->get('category/list/all', 'Book\CategoryController@getAll');
//        $api->get('category/list/hot', 'Book\CategoryController@getHot');

        $api->post('borrow/list', 'Book\BorrowController@getList');
        $api->post('borrow/add', 'Book\BorrowController@add');
        $api->get('borrow/id/{id}', 'Book\BorrowController@getDetail');
        $api->post('borrow/scan', 'Book\BorrowController@scan');
        $api->post('borrow/control', 'Book\BorrowController@control');

        $api->post('borrow/change', 'Book\BorrowController@change');

        $api->post('favorite/list', 'Book\FavoriteController@getList');
        $api->post('favorite/control', 'Book\FavoriteController@control');
        $api->post('favorite/check', 'Book\FavoriteController@check');

        $api->get('book/id/{id}', 'Book\DetailController@getDetail');
        $api->get('book/isbn/{isbn}', 'Book\DetailController@getDetailByIsbn');
        $api->get('book/location/{id}', 'Book\DetailController@getLocationDetail');
//        $api->get('author/id/{id}', 'BookController@getAuthorBook');

        $api->post('book/search', 'Book\SearchController@search');
    });
});

