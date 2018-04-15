<?php

function getAdminMenus($role_id){
	return [
		array(
			'id' => '1',
			'name' => '系统设置',
			'class' => '',
			'url' => '',
			'child' => array(
				array(
					'id' => '2',
					'name' => '管理员管理',
					'url' => 'admin/admin/',
					'class' => '',			
				),
				array(
					'id' => '3',
					'name' => '角色管理',
					'url' => 'admin/role/',
					'class' => '',	
				),
				array(
					'id' => '4',
					'name' => '菜单管理',
					'url' => 'admin/sidebar/',
					'class' => '',	
				),
				array(
					'id' => '5',
					'name' => '权限管理',
					'url' => 'admin/privilege/',
					'class' => '',	
				)						
			),
		)
	];
}


/**
 * 获取无线级分类列表
 */
function no_limit_category($array, $pid = 0, $level = 0) {
    static $arr=array();
    foreach ($array as $val) {
        if ($val['pid'] == $pid) {
            $val['level'] = $level;
            $arr[]=$val;
            no_limit_category($array, $val['id'], $level+1);
        }
    }
    return $arr;
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