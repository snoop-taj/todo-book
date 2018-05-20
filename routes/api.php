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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function() {

    Route::post('/register', 'AuthController@register');
    Route::post('/login', 'AuthController@login');
    Route::get('/personal_detail', 'AuthController@personalDetail');
});

Route::get('/users/friends', 'UserController@friends');
Route::post('/users/{user_id}/add_friend', 'UserController@addFriend');
Route::post('users/{user_id}/remove_friend', 'UserController@removeFriend');
Route::get('todos', 'TodoController@todos');

Route::apiResource('users', 'UserController');
Route::apiResource('todo', 'TodoController');
