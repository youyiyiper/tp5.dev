<?php

/**
 * 获取后台用户可以查看的菜单列表
 * 
 * @param  int 		$role_id 	角色id
 * @return array          		数组
 */
function getAdminMenus($role_id){
	//获取 管理员权限
	$list = get_session('AdminMenus');
	if (!empty($list)) {
		return $list;
	}

	//获取 角色对应的权限
	$rules = db('roles')->where('id',$role_id)->value('rules');
	if (empty($rules)) {
		return [];
	}

	//查询菜单
	$where[] = ['is_menu','=',1];
	$where[] = ['id','in',$rules];
	$list = db('privileges')->where($where)->field(['id','name','url','class','pid'])->select();
	if (empty($list)) {
		return [];
	}	

	//树形菜单
	$list = get_tree($list);
	if (empty($list)) {
		return [];
	}

	set_session('AdminMenus',$list);
	return $list;

	/*return [
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
	];*/
}

/**
 * 判断是否有权限
 */
function is_has_privilege($privilege_flag = ''){
	if (!$privilege_flag) {
		return false;
	}

	//获取权限
	$list = get_session('RoleHadprivilege');
	if (!empty($list)) {
		//判断是否有权限
		if(isset($list[$privilege_flag])){
			return true;
		}else{
			return false;
		}
	}

	//获取角色id
	$role_id = get_session_key_value('Admin.role_id');
	if (!$role_id) {
		return false;
	}

	//获取角色拥有的权限
	$rules = db('roles')->where('id',$role_id)->value('rules');
	if (empty($rules)) {
		return false;
	}

	//查询菜单
	$where[] = ['id','in',$rules];
	$list = db('privileges')->where($where)->field(['flag'])->select();
	if (empty($list)) {
		return false;
	}	

	//权限列表
	$privilege = [];
	foreach ($list as $value) {
		$privilege[$value['flag']] = $value['flag'];
	}

	$list = $privilege;
	//判断是否有权限
	if(isset($list[$privilege_flag])){
		//设置session
		set_session('RoleHadprivilege',$list);
		return true;
	}else{
		return false;
	}
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

/**
 * 验证是否是邮箱
 *
 * @param unknown $address 邮箱地址
 * @return boolean 是否是邮箱
 */
function is_email($address){
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",$address)) ? FALSE : TRUE;
}