<?php
namespace app\admin\library;

use app\common\model\Admins;

class AdminLib
{
	//状态
	const STATUS_VALID 		= 1;	//可用
	const STATUS_NO_VALID 	= 0;	//不可用

	/**
	 * 获取后台列表
	 */
	public static function getDataLists($param = array())
	{
		$map = array();
		if(!empty($param['name'])){
			$map[] =  ['name', 'like', $param['name'] . '%'];
		}		

		if(!empty($param['email'])){
			$map[] =  ['email', '=' , $param['email']];
		}	

		if(isset($param['status']) && is_numeric($param['status'])){
			$map[] =  ['status', '=' , (int)$param['status']];
		}		

		if(empty($map)){
			$map[] =  ['status', '=' , 1];
		}

		$list = Admins::where($map)->order('created_at desc,status desc')->paginate(10);
		return $list ? $list : [];
	}

	/**
	 * 获取信息
	 */
	public static function getInfoById($id)
	{
		return Admins::where('id', $id)->findOrFail();
	}

	/**
	 * 修改管理员信息
	 *
	 * @param 	array 	$where 	修改条件
	 * @param 	array 	$data 	修改内容
	 * @return 	array 			
	 */
	public static function updateData($where,$data)
	{
		$data['updated_at'] = date('Y-m-d H:i:s');
		return (new Admins)->save($data,$where);
	}

	/**
	 * 添加信息
	 *
	 * @param 	array 	$data 	修改内容
	 * @return 	array 			
	 */
	public static function addData($data)
	{
		$data['created_at'] = $data['updated_at'] = date('Y-m-d H:i:s');
		$model   = new Admins;
		return $model->save($data) ? $model->id : 0;
	}

	/**
	 * 通过id获取管理员信息
	 *
	 * @param 	string 	$id 	id
	 * @return 	array 			
	 */
	public static function getAdminInfoById($id)
	{
		$res = Admins::where('id',$id)->find();
		return $res ? $res : [];
	}	

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

	/**
	 * 执行修改密码
	 *
	 * @param 	string 	$post 	表单提交信息
	 * @return  array
	 */
	public static function handleChangePwd($post){
		if (empty($post['name'])) {
			return data_format_flash(lang('code_param_must'),lang('tips_param_must'));
		}

		if (empty($post['password']) || empty($post['password_confirmation'])) {
			return data_format_flash(lang('code_param_must'),lang('tips_param_must'));
		}

		if ($post['password'] !== $post['password_confirmation']) {
			return data_format_flash(lang('code_password_no_equal'),lang('tips_password_no_equal'));
		}

		$data['password'] 	= md5($post['password']);
		$data['name'] 		= $post['name'];
		
		$adminSession = get_session('Admin');

		$flag = self::updateData(array('id' => $adminSession['id']),$data);
		if (!$flag) {
			return data_format_flash(lang('code_db_update_err'),lang('tips_update_info_err'));
		}else{
			$res = self::getAdminInfoById($adminSession['id']);
			unset($res['password']);
			set_session('Admin',$res);
			return data_format(lang('code_success'),lang('tips_update_info_suc'));
		}
	}

	/**
	 * 执行修改信息操作
	 *
	 * @param 	string 	$post 	表单提交信息
	 * @return  array
	 */
	public static function handleUpdate($post,$id){
		if (!empty($post['name'])) {
			$data['name'] 		= $post['name'];
		}

		if (!empty($post['password']) && !empty($post['password_confirmation'])) {
			if ($post['password'] !== $post['password_confirmation']) {
				return data_format_flash(lang('code_password_no_equal'),lang('tips_password_no_equal'));
			}

			$data['password'] = md5($post['password']);
		}

		if (!empty($post['role_id'])) {
			$data['role_id'] 	= $post['role_id'] > 0 ? $post['role_id'] : 0;
		}		
		
		if (!empty($post['headimg'])) {
			$data['headimg'] 	= $post['headimg'];
		}

		$flag = self::updateData(array('id' => $id),$data);
		if (!$flag) {
			return data_format_flash(lang('code_db_update_err'),lang('tips_update_info_err'));
		}else{
			return data_format(lang('code_success'),lang('tips_update_info_suc'));
		}		
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

		if (empty($post['email'])) {
			return data_format_flash(lang('code_param_must'),lang('tips_param_must'));
		}		

		if (empty($post['password']) || empty($post['password_confirmation'])) {
			return data_format_flash(lang('code_param_must'),lang('tips_param_must'));
		}

		if ($post['password'] !== $post['password_confirmation']) {
			return data_format_flash(lang('code_password_no_equal'),lang('tips_password_no_equal'));
		}

		//检查邮箱是否被占用
		$ret = self::getAdminInfoByEmail($post['email']);
		if (!empty($ret)) {
			return data_format_flash(lang('code_email_exists'),lang('tips_email_exists'));
		}

		$data['password'] 	= md5($post['password']);
		$data['name'] 		= $post['name'];
		$data['email'] 		= $post['email'];
		$data['role_id'] 	= $post['role_id'] > 0 ? $post['role_id'] : 0;

		$flag = self::addData($data);
		if (!$flag) {
			return data_format_flash(lang('code_db_insert_err'),lang('tips_add_info_err'));
		}else{
			return data_format(lang('code_success'),lang('tips_add_info_suc'));
		}		
	}	
}