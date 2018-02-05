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
    Route::get('users/{user}/messages', 'API\UserController@messages');
    // 用户组织
    Route::get('users/{user}/organizations', 'API\UserController@organizations');
    // 用户选课
    Route::get('users/{user}/lectures', 'API\UserController@lectures');
    // 用户通知
    Route::get('users/{user}/notifications', 'API\UserController@notifications');
    // 用户角色
    Route::get('users/{user}/roles', 'API\UserController@roles');
    // 用户权限
    Route::get('users/{user}/permissions', 'API\UserController@permissions');
    // 用户申请
    Route::get('users/{user}/applications', 'API\UserController@applications');
    // 更改用户密码
    Route::patch('users/{user}/password', 'API\UserController@updatePassword');

    // 角色
    Route::apiResource('roles', 'API\RoleController');
    // 给角色同步权限
    Route::put('roles/{id}/permissions', 'API\RoleController@syncPermissions');
    // 给角色添加权限
    Route::post('roles/{id}/permissions', 'API\RoleController@attachPermissions');
    // 给角色撤销权限
    Route::delete('roles/{id}/permissions', 'API\RoleController@detachPermissions');
     // 给角色同步用户
    Route::put('roles/{id}/users', 'API\RoleController@syncUsers');
    // 给角色添加用户
    Route::post('roles/{id}/users', 'API\RoleController@attachUsers');
    // 从角色移除用户
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
    // 课程
    Route::apiResource('courses', 'API\CourseController');
    // 试卷
    Route::apiResource('papers', 'API\PaperController');
    // 试卷章节
    Route::namespace('API\Papers')->group(function (){
            Route::apiResource('papers/{paper}/sections', 'PaperSectionController');
        });
    // 考试
    Route::apiResource('exams', 'API\ExamController');
    // 讲课
    Route::apiResource('lectures', 'API\LectureController');
    // 获取讲课的用户
    Route::get('lectures/{id}/users', 'API\LectureController@users');
    // 添加用户到讲课(选课)
    Route::post('lectures/{id}/users', 'API\LectureController@addUsers');
    // 从授课删除用户(退课)
    Route::delete('lectures/{id}/users', 'API\LectureController@deleteUsers');
    // 组织
    Route::apiResource('organizations', 'API\OrganizationController');
    // 获取组织的用户
    Route::get('organizations/{id}/users', 'API\OrganizationController@users');
    // 添加用户到组织
    Route::post('organizations/{id}/users', 'API\OrganizationController@addUsers');
    // 从组织删除用户
    Route::delete('organizations/{id}/users', 'API\OrganizationController@deleteUsers');
    // 同步组织用户
    Route::put('organizations/{id}/users', 'API\OrganizationController@syncUsers');
    // 申请
    Route::apiResource('applications', 'API\ApplicationController');
    // 同意申请
    Route::post('applications/{application}/accept', 'API\ApplicationController@accept');
    // 拒绝申请
    Route::post('applications/{application}/reject', 'API\ApplicationController@reject');
    // 标签
    Route::apiResource('tags', 'API\TagController');
});
