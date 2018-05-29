<?php
namespace app\admin\library;

use app\common\model\Configs;
use app\common\library\CommonLib;

class ConfigLib extends CommonLib
{
	/**
     * 获取所有菜单
     */
    public static function getAllConfig($get = array())
    {
    	$map = [];

		$model = Configs::order('created_at desc');

		if (!empty($get['name'])) {
			$map[] =  ['name', '=', $get['name']];
		}

		if (!empty($get['title'])) {
			$map[] =  ['title', 'like', '%'.$get['title'].'%'];
		}		

		if (!empty($map)) {
			$model = $model->where($map);
		}		

        $list = $model->paginate(15);
		return $list ? $list : [];
    }

	/**
	 * 获取信息
	 */
	public static function getInfoById($id)
	{
		return Configs::where('id', $id)->findOrFail();
	}

	/**
	 * 执行添加信息操作
	 *
	 * @param 	string 	$post 	表单提交信息
	 * @return  array
	 */
	public static function handleAdd($post){
		$validate = new \app\admin\validate\Config;
        if (!$validate->check($post)) {
            return data_format_flash(lang('code_error'),$validate->getError());
        }

		$data['name'] 		= $post['name'];
		$data['content'] 		= !empty($post['content']) ? $post['content'] : '';
		$data['title'] 		= !empty($post['title']) ? $post['title'] : '';
		
		$flag = self::addData($data,(new Configs));
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
		
		if (!empty($post['content'])) {
			$data['content'] 	= $post['content'];
		}

		if (!empty($post['title'])) {
			$data['title'] 	= $post['title'];
		}		
		
		$flag = self::updateData(array('id' => $id),$data,(new Configs));
		if (!$flag) {
			return data_format_flash(lang('code_db_update_err'),lang('tips_update_info_err'));
		}else{
			return data_format(lang('code_success'),lang('tips_update_info_suc'));
		}		
	}
}