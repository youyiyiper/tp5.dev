<?php

// 自定义语言包
return [
	###############################状态码######################################
	'code_success' 					=> 0,
	'code_error' 					=> -1,
	'code_param_must' 				=> 2,

	//邮箱
	'code_email_not_exists' 		=> 100,
	'code_email_exists' 			=> 101,
	'code_status_no_valid' 			=> 102,

	//登录相关
	'code_incorrect_password' 		=> 300,
	'code_password_no_equal' 		=> 301,
	
	//权限
	'code_privilege_exists' 		=> 400,
	'code_role_exists' 				=> 410,

	// 700-799 数据库相关
	'code_db_search_err'     		=> 700,  // 数据库查找数据失败
	'code_db_insert_err'     		=> 701,  // 数据库插入数据失败
	'code_db_update_err'     		=> 702,  // 数据库更新数据失败
	'code_db_delete_err'    		=> 703,  // 数据库删除数据失败
	'code_db_search_nothing' 		=> 704,  // 数据库查找不到数据
	'code_db_trans_err'      		=> 705,  // 数据库事务处理失败
	'code_db_has_exist'      		=> 706,  // 数据库已有相同数据


	###############################提示信息######################################
	'tips_success_tips' 			=> '执行成功',
	'tips_error' 					=> '执行失败',
	'tips_param_must' 				=> '参数必须',
	
	//邮箱
	'tips_email_not_exists' 		=> '邮箱不存在',
	'tips_status_no_valid' 			=> '状态不可用',
	'tips_login_error' 				=> '帐号或密码错误',
	'tips_email_exists' 			=> '邮箱已存在',

	//登录
	'tips_password_no_equal'		=> '两次密码不一致',

	//权限
	'tips_privilege_exists' 		=> '权限已存在',
	'tips_role_exists' 				=> '角色已存在',

	//数据库相关
	'tips_search_nothing'       	=> '没找到更多数据!', 
	'tips_add_info_suc'       		=> '添加信息成功!', 
	'tips_add_info_err'       		=> '添加信息失败!', 
	'tips_update_info_suc'    		=> '修改信息成功!', 
	'tips_update_info_err'    		=> '修改信息失败!', 
	'tips_del_info_suc'       		=> '删除信息成功!', 
	'tips_del_info_err'       		=> '删除信息失败!',
	'tips_invest_trans_err'      	=> '事务处理失败!',
	'tips_db_has_exist'				=> '已存在相同的记录',
];