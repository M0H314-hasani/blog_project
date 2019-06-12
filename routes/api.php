<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('auth')->middleware('api')->group(function (){
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::prefix('user')->group(function (){
    Route::get('/collections', 'UserCollectionController@followedCollections');

    Route::get('/{user}/follow','UserSociabilityController@follow');
    Route::get('/{user}/followers','UserSociabilityController@followers');
    Route::get('/{user}/followings','UserSociabilityController@following');

    Route::get('/{user}','UserController@index');
    Route::post('register', 'UserController@register');
    Route::patch('/', 'UserController@updateUserInfo');
    Route::post('/avatar/upload', 'UserController@uploadAvatar');


});

Route::prefix('collection')->group(function (){
    Route::get('/', 'CollectionController@index');
    Route::post('/', 'CollectionController@create');
    Route::delete('/{collection}', 'CollectionController@destroy');

    Route::get('/{collection}/follow', 'UserCollectionController@followCollection');
});

Route::prefix('post')->group(function (){
    Route::get('/', 'PostController@index');
    Route::post('/', 'PostController@create');
    Route::get('/{post}/related/{quantity}', 'PostController@relatedPosts');
    Route::post('/{post}/featured-image/upload', 'PostController@uploadFeaturedImage');
    Route::patch('/{post}/status', 'PostController@changeStatus');
    Route::patch('/{post}/accessibility', 'PostController@changeAccessibility');
    Route::patch('/{post}', 'PostController@update');
    Route::get('/{post}', 'PostController@show');
});
