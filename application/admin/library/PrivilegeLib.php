<?php
namespace app\admin\library;

use app\common\model\Privileges;
use app\common\library\CommonLib;

/**
 * 权限类库
 */
class PrivilegeLib extends CommonLib
{
	/**
	 * 获取所有列表
	 */
	public static function getDataLists()
	{
		$list = Privileges::select();
		return $list ? $list : array();		
	}

	/**
	 * 获取信息
	 */
	public static function getInfoById($id)
	{
		return Privileges::where('id', $id)->findOrFail();
	}

	/**
	 * 通过权限标识获取权限信息
	 *
	 * @param 	string 	$flag 	权限
	 * @return 	array 			
	 */
	public static function getPrivilegeInfoByFlag($flag,$id = 0)
	{
		$map[] = ['flag','=',$flag];
		if ($id > 0) {
			$map[] = ['id','<>',$id];
		}
		
		$res = Privileges::where('flag',$flag)->find();
		return $res ? $res : [];
	}

	/**
	 * 执行添加信息操作
	 *
	 * @param 	string 	$post 	表单提交信息
	 * @return  array
	 */
	public static function handleAdd($post){
		if (empty($post['name'])) {
			return data_format_flash(lang('code_param_must'),lang('tips_param_must'));
		}

		if (empty($post['flag'])) {
			return data_format_flash(lang('code_param_must'),lang('tips_param_must'));
		}

		//检查权限标识是否被占用
		$ret = self::getPrivilegeInfoByFlag($post['flag']);
		if (!empty($ret)) {
			return data_format_flash(lang('code_privilege_exists'),lang('tips_privilege_exists'));
		}		

		$data['flag'] 		= $post['flag'];
		$data['name'] 		= $post['name'];
		$data['desc'] 		= $post['desc'] ? $post['desc'] : '';
		$data['pid'] 		= $post['pid'] > 0 ? $post['pid'] : 0;
		if (!empty($post['is_menu'])) {
			$data['is_menu'] = 1;
			$data['url'] 	 = $post['url'];
			$data['class'] 	 = $post['class'];
		} else {
			$data['is_menu'] = 0;
			$data['url'] 	 = '';
			$data['class'] 	 = '';			
		}

		$flag = self::addData($data,(new Privileges));
		if (!$flag) {
			return data_format_flash(lang('code_db_insert_err'),lang('tips_add_info_err'));
		} else {
			return data_format(lang('code_success'),lang('tips_add_info_suc'));
		}		
	}

	/**
	 * 执行修改信息操作
	 *
	 * @param 	string 	$post 	表单提交信息
	 * @return  array
	 */
	public static function handleUpdate($post,$id){
		if (empty($post['name'])) {
			return data_format_flash(lang('code_param_must'),lang('tips_param_must'));
		}

		if (empty($post['flag'])) {
			return data_format_flash(lang('code_param_must'),lang('tips_param_must'));
		}

		//检查权限标识是否被占用
		$ret = self::getPrivilegeInfoByFlag($post['flag'],$id);
		if (!empty($ret)) {
			return data_format_flash(lang('code_privilege_exists'),lang('tips_privilege_exists'));
		}		
		
		$data['flag'] 		= $post['flag'];
		$data['name'] 		= $post['name'];
		$data['desc'] 		= $post['desc'] ? $post['desc'] : '';
		$data['pid'] 		= $post['pid'] > 0 ? $post['pid'] : 0;
		if (!empty($post['is_menu'])) {
			$data['is_menu'] = 1;
			$data['url'] 	 = $post['url'];
			$data['class'] 	 = $post['class'];
		} else {
			$data['is_menu'] = 0;
			$data['url'] 	 = '';
			$data['class'] 	 = '';			
		}

		$flag = self::updateData(array('id' => $id),$data,(new Privileges));
		if (!$flag) {
			return data_format_flash(lang('code_db_update_err'),lang('tips_update_info_err'));
		} else {
			return data_format(lang('code_success'),lang('tips_update_info_suc'));
		}		
	}
}