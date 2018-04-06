<?php

//后台登录
Route::get('admin/login/:type', 'admin/login/index');
Route::post('admin/login/doLogin', 'admin/login/doLogin');

//后台登录
Route::get('admin/index', 'admin/index/index');
Route::get('admin/manager', 'admin/manager/setting');

Route::get('admin/admin/', 'admin/admin/index');
Route::get('admin/admin/create', 'admin/admin/create');
Route::get('admin/admin/edit', 'admin/admin/edit');

Route::get('admin/article/', 'admin/article/index');
Route::get('admin/article/create', 'admin/article/create');
Route::get('admin/article/edit', 'admin/article/edit');