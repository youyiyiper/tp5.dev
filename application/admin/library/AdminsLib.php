<?php
namespace app\admin\library;

use app\common\model\Admins;

class AdminsLib
{
	//状态
	const STATUS_VALID 		= 1;	//可用
	const STATUS_NO_VALID 	= 0;	//不可用

	/**
	 * 通过邮箱获取管理员信息
	 *
	 * @param 	string 	$email 	邮箱
	 * @return 	array 			
	 */
	public static function getAdminInfoByEmail($email)
	{
		$res = Admins::where('email',$email)->find();
		return $res ? $res : [];
	}
}