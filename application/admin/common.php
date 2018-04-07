<?php

function getAdminMenus(){
	return [];
}

/**
 * 获取角色名称
 */
function get_status_title($status) {
	$title = '';
	switch ($status) {
		case 0:
			$title = '不可用';
			break;
		case 1:
			$title = '可用';
			break;
	}
	return $title;
}

/**
 * 获取角色名称
 */
function get_role_title($role_id) {
	$res = Db::name('roles')->where('id',$role_id)->field('name')->find();
	return !empty($res['name']) ? $res['name'] : '';
}