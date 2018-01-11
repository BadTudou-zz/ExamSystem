<?php

use Illuminate\Http\Request;

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
// 验证码
Route::post('captchas', 'API\CaptchaController@store');

Route::prefix('v1')->middleware(['auth:api'])->group(function () {
    // 用户
    Route::apiResource('users', 'API\UserController');
    // 用户消息
    Route::get('users/{id}/messages', 'API\MessageController@messages');
    // 用户通知
    Route::get('users/{id}/notifications', 'API\NotificationController@notifications');
    // 更改用户密码
    Route::patch('users/{user}/password', 'API\UserController@updatePassword');

    // 角色
    Route::apiResource('roles', 'API\RoleController');
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

    // 权限
    Route::apiResource('permissions', 'API\PermissionController');
    // 消息
    Route::apiResource('messages', 'API\MessageController');
    // 通知
    Route::apiResource('notifications', 'API\NotificationController');
    // 评论
    Route::apiResource('omments', 'API\CommentController');
    // 课程
    Route::apiResource('courses', 'API\CourseController');
    // 问题
    Route::apiResource('questions', 'API\QuestionController');
});
