<?php

//后台忘记密码
Route::get('admin/login/email', 'admin/Login/email');
Route::post('admin/login/doEmail', 'admin/Login/doEmail');
Route::get('admin/validEmail', 'admin/Login/validEmail');
Route::get('admin/Login/reset', 'admin/Login/reset');
Route::post('admin/Login/doReset', 'admin/Login/doReset');

//后台登录
Route::get('admin/login/:type', 'admin/Login/index');
Route::post('admin/login/doLogin', 'admin/Login/doLogin');


//后台管理员中心
Route::get('admin/index', 'admin/Index/index');
Route::get('admin/manager', 'admin/Manager/setting');
Route::post('admin/saveHeadimg', 'admin/Manager/saveHeadimg');

Route::post('common/upload', 'admin/Common/upload');
Route::post('common/handle', 'admin/Common/handle');

Route::get('admin/changePwd', 'admin/Manager/changePwd');
Route::post('admin/postChangePwd','admin/Manager/postChangePwd');
Route::get('admin/logout','admin/Manager/logout');

//各模块管理
Route::resource('admin/admin','admin/Admin');
Route::resource('admin/role','admin/Role');
Route::resource('admin/privilege','admin/Privilege');
Route::resource('admin/config','admin/Config');