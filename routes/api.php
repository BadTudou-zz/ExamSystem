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
    // 给角色添加权限
    Route::post('roles/{id}/permissions', 'API\RoleController@attachPermissions');
    // 给角色撤销权限
    Route::delete('roles/{id}/permissions', 'API\RoleController@detachPermissions');
    // 给角色添加用户
    Route::post('roles/{id}/users', 'API\RoleController@attachUsers');
    // 从角色中移除用户
    Route::delete('roles/{id}/users', 'API\RoleController@detachUsers');
    // 获取角色的权限
    Route::get('roles/{id}/permissions', 'API\RoleController@permissions');
    // 获取角色的用户
    Route::get('roles/{id}/users', 'API\RoleController@users');
});
