<?php

use Illuminate\Http\Request;

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::post('logout', 'API\UserController@logout')->middleware(['auth:api']);
// 验证码
Route::post('captchas', 'API\CaptchaController@store');


//  导入+上传

Route::group(['prefix' => '/v1'], function () {
//    Route::post('webrtc', 'TestController@webrtc');
//
//
//
//    Route::post('questions/import', 'API\ExcelController@import');
//
//
//
//    Route::post('upload/lecture/video', 'API\VideoController@uploadVideo');
//    Route::post('upload/lecture/insert/video', 'API\VideoController@insert');
//    Route::post('upload/lecture/selectForUserid/video', 'API\VideoController@selectForUserid');
//    Route::post('upload/lecture/selectForCid/video', 'API\VideoController@selectForCid');
//    Route::post('upload/lecture/selectAll/video', 'API\VideoController@selectAll');
//    Route::post('upload/lecture/delete/video', 'API\VideoController@delete');
//    Route::post('upload/lecture/update/video', 'API\VideoController@update');
//
//    Route::post('upload/lecture/document', 'API\DocumentController@uploadVideo');
//    Route::post('upload/lecture/insert/document', 'API\DocumentController@insert');
//    Route::post('upload/lecture/selectForUserid/document', 'API\DocumentController@selectForUserid');
//    Route::post('upload/lecture/selectForCid/document', 'API\DocumentController@selectForCid');
//    Route::post('upload/lecture/selectAll/document', 'API\DocumentController@selectAll');
//    Route::post('upload/lecture/delete/document', 'API\DocumentController@delete');
//    Route::post('upload/lecture/update/document', 'API\DocumentController@update');
//
//
//    Route::post('preview/insert', 'API\PreviewController@insert');
//    Route::post('preview/publish', 'API\PreviewController@publish');
//    Route::post('preview/update', 'API\PreviewController@update');
//    Route::post('preview/delete', 'API\PreviewController@delete');
//    Route::post('preview/selectForUserid', 'API\PreviewController@selectForUserid');
//    Route::post('preview/selectForCid', 'API\PreviewController@selectForCid');
//    Route::post('preview/selectAll', 'API\PreviewController@selectAll');
//
//
//    Route::post('questions/import/student', 'API\ExcelController@importStudent');
//    Route::post('questions/import/teacher', 'API\ExcelController@teacher');
//
//
//    Route::post('discuss/publishDiscuss', 'API\DiscussController@publishDiscuss');
//    Route::post('discuss/updateDiscuss', 'API\DiscussController@updateDiscuss');
//    Route::post('discuss/deleteDiscuss', 'API\DiscussController@deleteDiscuss');
//    Route::post('discuss/selectDiscussForUserid', 'API\DiscussController@selectDiscussForUserid');
//    Route::post('discuss/selectDiscussForLid', 'API\DiscussController@selectDiscussForLid');
//    Route::post('discuss/selectDiscussAll', 'API\DiscussController@selectDiscussAll');
//
//    Route::post('discuss/selectDiscussAndReply', 'API\DiscussController@selectDiscussAndReply');
//
//
//    Route::post('discuss/replyDiscuss', 'API\DiscussController@replyDiscuss');
//    Route::post('discuss/deleteReply', 'API\DiscussController@deleteReply');
//    Route::post('discuss/selectReplyForUserid', 'API\DiscussController@selectReplyForUserid');
//    Route::post('discuss/selectReplyForDid', 'API\DiscussController@selectReplyForDid');
//    Route::post('discuss/selectReplyAll', 'API\DiscussController@selectReplyAll');



});

Route::prefix('v1')->middleware(['auth:api'])->group(function () {

    Route::post('questions/import', 'API\ExcelController@import');



    Route::post('upload/lecture/video', 'API\VideoController@uploadVideo');
    Route::post('upload/lecture/insert/video', 'API\VideoController@insert');
    Route::post('upload/lecture/selectForUserid/video', 'API\VideoController@selectForUserid');
    Route::post('upload/lecture/selectForCid/video', 'API\VideoController@selectForCid');
    Route::post('upload/lecture/selectAll/video', 'API\VideoController@selectAll');
    Route::post('upload/lecture/delete/video', 'API\VideoController@delete');
    Route::post('upload/lecture/update/video', 'API\VideoController@update');

    Route::post('upload/lecture/document', 'API\DocumentController@uploadDoc');
    Route::post('upload/lecture/insert/document', 'API\DocumentController@insert');
    Route::post('upload/lecture/selectForUserid/document', 'API\DocumentController@selectForUserid');
    Route::post('upload/lecture/selectForCid/document', 'API\DocumentController@selectForCid');
    Route::post('upload/lecture/selectAll/document', 'API\DocumentController@selectAll');
    Route::post('upload/lecture/delete/document', 'API\DocumentController@delete');
    Route::post('upload/lecture/update/document', 'API\DocumentController@update');


    Route::post('preview/insert', 'API\PreviewController@insert');
    Route::post('preview/publish', 'API\PreviewController@publish');
    Route::post('preview/update', 'API\PreviewController@update');
    Route::post('preview/delete', 'API\PreviewController@delete');
    Route::post('preview/selectForUserid', 'API\PreviewController@selectForUserid');
    Route::post('preview/selectForCid', 'API\PreviewController@selectForCid');
    Route::post('preview/selectAll', 'API\PreviewController@selectAll');


    Route::post('questions/import/student', 'API\ExcelController@importStudent');
    Route::post('questions/import/teacher', 'API\ExcelController@importTeacher');


    Route::post('discuss/publishDiscuss', 'API\DiscussController@publishDiscuss');
    Route::post('discuss/updateDiscuss', 'API\DiscussController@updateDiscuss');
    Route::post('discuss/deleteDiscuss', 'API\DiscussController@deleteDiscuss');
    Route::post('discuss/selectDiscussForUserid', 'API\DiscussController@selectDiscussForUserid');
    Route::post('discuss/selectDiscussForLid', 'API\DiscussController@selectDiscussForLid');
    Route::post('discuss/selectDiscussAll', 'API\DiscussController@selectDiscussAll');

    Route::post('discuss/selectDiscussAndReply', 'API\DiscussController@selectDiscussAndReply');


    Route::post('discuss/replyDiscuss', 'API\DiscussController@replyDiscuss');
    Route::post('discuss/deleteReply', 'API\DiscussController@deleteReply');
    Route::post('discuss/selectReplyForUserid', 'API\DiscussController@selectReplyForUserid');
    Route::post('discuss/selectReplyForDid', 'API\DiscussController@selectReplyForDid');
    Route::post('discuss/selectReplyAll', 'API\DiscussController@selectReplyAll');





    Route::post('/test1', 'TestController@test');
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
    // 用户考试
    Route::get('users/{user}/exams', 'API\UserController@exams');
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
    // 题目
    Route::apiResource('questions', 'API\QuestionController');
    // 题目类型
    Route::apiResource('questionTypes', 'API\QuestionTypeController');
    // 题目类型的全部题目
    Route::get('questionTypes/{id}/questions', 'API\QuestionTypeController@questions')->name('questionTypes.questions');
    // 课程
    Route::apiResource('courses', 'API\CourseController');
    // 试卷
    Route::apiResource('papers', 'API\PaperController');
    //试卷-题目
    Route::get('papers/{paper}/questions', 'API\PaperController@questions');
    // 试卷-分数
    Route::get('papers/{paper}/scores', 'API\PaperController@scores');
    // 试卷-自动选择题目
    Route::post('papers/{paper}/maker', 'API\PaperController@maker');
    // 试卷章节
    Route::namespace('API\Papers')->group(function (){
            Route::apiResource('papers/{paper}/sections', 'PaperSectionController');
        });
    // 考试
    Route::apiResource('exams', 'API\ExamController');
    // 考试的用户
    Route::get('exams/{id}/users', 'API\ExamController@users');
    // 提交考试
    Route::post('exams/{id}/answer', 'API\ExamController@answer');
    // 添加用户到考试
    Route::post('exams/{id}/users', 'API\ExamController@addUsers');
    // 从考试删除用户
    Route::delete('exams/{id}/users', 'API\ExamController@deleteUsers');
    // 考试开始
    Route::post('exams/{id}/start', 'API\ExamController@start');
    // 考试结束
    Route::post('exams/{id}/stop', 'API\ExamController@stop');
    // 考试批改
    Route::post('exams/{id}/correct', 'API\ExamController@correct');
    // 考试评测
    Route::post('exams/{id}/check', 'API\ExamController@check');
    // 用户开始考试
    Route::post('exams/{id}/begin', 'API\ExamController@begin');
    // 用户结束考试
    Route::post('exams/{id}/finish', 'API\ExamController@finish');
    // 用户查看考试结果
    Route::get('exams/{id}/score', 'API\ExamController@score');
    // 用户查看考试全部用户结果
    Route::get('exams/{id}/scores', 'API\ExamController@scores');
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
