<?php
namespace app\admin\library;

use app\common\model\Roles;
use app\common\library\CommonLib;

class RoleLib extends CommonLib
{
	//角色状态
	const STATUS_VALID 		= 1;	//可用
	const STATUS_NO_VALID 	= 0;	//不可用

	/**
	 * 获取下拉菜单
	 */
	public static function getDataLists($get = array())
	{	
		$map = [];

		$model = Roles::field('id,name,status,desc,created_at,updated_at');

		if(!empty($get['name'])){
			$map[] =  ['name', '=' , $get['name']];
			$model = $model->where($map);
		}

		$list = $model->order('status desc,created_at desc')->paginate(15);
		return $list;		
	}

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

	/**
	 * 获取信息
	 */
	public static function getInfoByName($name,$id = 0)
	{
		if ($id > 0) {
			$where[] = ['id','<>',$id];
		}
		$where[] = ['name','=',$name];
		return Roles::where($where)->find();
	}

	/**
	 * 获取信息
	 */
	public static function getInfoById($id)
	{
		return Roles::where('id', $id)->findOrFail();
	}

	/**
	 * 执行添加信息操作
	 *
	 * @param 	string 	$post 	表单提交信息
	 * @return  array
	 */
	public static function handleAdd($post){
		/*$validate = new \app\admin\validate\Role;
        if (!$validate->check($post)) {
          return data_format_flash(lang('code_error'),$validate->getError());
        }*/

		if (empty($post['name'])) {
			return data_format_flash(lang('code_param_must'),lang('tips_param_must'));
		}

		$data['name'] 		= $post['name'];
		$data['desc'] 		= !empty($post['desc']) ? $post['desc'] : '';
		$data['status'] 	= !empty($post['status']) ? 1 : '0';
		$data['rules'] 		= implode(',', $post['permission']);

		//检查角色是否被占用
		$ret = self::getInfoByName($post['name']);
		if (!empty($ret)) {
			return data_format_flash(lang('code_role_exists'),lang('tips_role_exists'));
		}
		
		$flag = self::addData($data,(new Roles));
		if (!$flag) {
			return data_format_flash(lang('code_db_insert_err'),lang('tips_add_info_err'));
		}else{
			return data_format_flash(lang('code_success'),lang('tips_add_info_suc'),'success');
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

		//检查角色是否被占用
		$ret = self::getInfoByName($post['name'],$id);
		if (!empty($ret)) {
			return data_format_flash(lang('code_role_exists'),lang('tips_role_exists'));
		}
		
		$data['name'] 		= $post['name'];
		$data['desc'] 		= !empty($post['desc']) ? $post['desc'] : '';
		$data['status'] 	= !empty($post['status']) ? 1 : '0';
		$data['rules'] 		= implode(',', $post['permission']);

		$flag = self::updateData(array('id' => $id),$data,(new Roles));
		if (!$flag) {
			return data_format_flash(lang('code_db_update_err'),lang('tips_update_info_err'));
		}else{
			return data_format(lang('code_success'),lang('tips_update_info_suc'));
		}		
	}
}