<?php
namespace app\admin\library;

use app\common\model\Roles;

class RoleLib
{
	//角色状态
	const STATUS_VALID 		= 1;	//可用
	const STATUS_NO_VALID 	= 0;	//不可用

	/**
	 * 获取下拉菜单
	 */
	public static function getOptionData($map = array())
	{
		if(empty($map)){
			$map[] =  ['status', '=' , 1];
		}		

		$list = Roles::where($map)->field('id,name')->order('status desc,created_at desc')->select();
		return $list;		
	}
}