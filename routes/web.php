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


Auth::routes();

<<<<<<< HEAD
Route::get('/home', 'HomeController@index')->name('home');
=======
//欢迎界面
// Route::get('/', function() {
// 	return view('welcome');
// });

Route::get('/', function () {
		return view('index');
});

//主页
Route::get('home', function() {
	return view('home');
});
//用户-个人中心
Route::get('users/{id}', function ($id) {
    return view('users.show');
});
//用户-更改密码
Route::get('users/{id}/password', function ($id) {
    return view('users.password');
});

//组织
Route::get('organizations/{id}', function ($id) {
    return view('organizations.show');
});

//课程
Route::get('courses/{id}', function ($id) {
    return view('courses.show');
});

//授课
Route::get('lectures/{id}', function ($id) {
    return view('lectures.show');
});

//题目
Route::get('questions/{id}', function ($id) {
    return view('questions.show');
});

//角色
Route::get('roles/{id}', function ($id) {
    return view('roles.show');
});

//申请
Route::get('applications/{id}', function ($id) {
    return view('applications.show');
});


// test
Route::get('/test', function () {
    return view('test');
});

Route::get('/test1', 'TestController@test');
>>>>>>> master
