<?php

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
Route::resource('admin/sidebar','admin/Sidebar');