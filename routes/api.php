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

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::prefix('v1')->middleware(['auth:api'])->group(function () {

    // 用户
    Route::apiResource('users', 'API\UserController');
    // 角色
    Route::apiResource('roles', 'API\RoleController');
    // 权限
    Route::apiResource('permissions', 'API\PermissionController');
});
