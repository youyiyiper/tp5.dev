<?php
namespace app\admin\library;

use app\common\model\Sidebars;

class SidebarLib
{
	/**
	 * 修改信息
	 *
	 * @param 	array 	$where 	修改条件
	 * @param 	array 	$data 	修改内容
	 * @return 	array 			
	 */
	public static function updateData($where,$data)
	{
		$data['updated_at'] = date('Y-m-d H:i:s');
		return (new Sidebars)->save($data,$where);
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
		$model   = new Sidebars;
		return $model->save($data) ? $model->id : 0;
	}

	/**
     * 获取所有菜单
     */
    public static function getAllSidebar()
    {
        $list = Sidebars::order('created_at desc')->select()->toArray();
		return $list ? $list : [];
    }

	/**
	 * 获取下拉菜单
	 */
	public static function getOptionData($map = array())
	{
		if(empty($map)){
			$map[] =  ['pid', '=' , 0];
		}		

		$list = Sidebars::where($map)->field('id,name,pid')->order('created_at desc')->select();
		return $list ? $list : [];		
	}

	/**
	 * 获取信息
	 */
	public static function getInfoById($id)
	{
		return Sidebars::where('id', $id)->findOrFail();
	}

	/**
	 * 执行添加信息操作
	 *
	 * @param 	string 	$post 	表单提交信息
	 * @return  array
	 */
	public static function handleAdd($post){
		$validate = new \app\admin\validate\Sidebar;
        if (!$validate->check($post)) {
            return data_format_flash(lang('code_error'),$validate->getError());
        }

		$data['name'] 		= $post['name'];
		$data['class'] 		= !empty($post['class']) ? $post['class'] : '';
		$data['url'] 		= !empty($post['url']) ? $post['url'] : '';
		$data['pid'] 		= !empty($post['pid']) ? $post['pid'] : '0';

		$flag = self::addData($data);
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
		if (!empty($post['name'])) {
			$data['name'] 		= $post['name'];
		}

		if (!empty($post['pid'])) {
			$data['pid'] 	= $post['pid'] > 0 ? $post['pid'] : 0;
		}		
		
		if (!empty($post['class'])) {
			$data['class'] 	= $post['class'];
		}

		if (!empty($post['url'])) {
			$data['url'] 	= $post['url'];
		}		

		$flag = self::updateData(array('id' => $id),$data);
		if (!$flag) {
			return data_format_flash(lang('code_db_update_err'),lang('tips_update_info_err'));
		}else{
			return data_format(lang('code_success'),lang('tips_update_info_suc'));
		}		
	}
}