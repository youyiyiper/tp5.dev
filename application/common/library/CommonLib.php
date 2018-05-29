<?php
namespace app\common\library;

class CommonLib
{
	/**
	 * 修改信息
	 *
	 * @param 	array 	$where 	修改条件
	 * @param 	array 	$data 	修改内容
	 * @param 	object 	$model 	事例对象
	 * @return 	array 			
	 */
	public static function updateData($where,$data,$model)
	{
		$data['updated_at'] = date('Y-m-d H:i:s');
		return $model->save($data,$where);
	}

	/**
	 * 添加信息
	 *
	 * @param 	array 	$data 	修改内容
	 * @param 	object 	$model 	事例对象
	 * @return 	array 			
	 */
	public static function addData($data,$model)
	{
		$data['created_at'] = $data['updated_at'] = date('Y-m-d H:i:s');
		return $model->save($data) ? $model->id : 0;
	}

	/**
	 * 删除信息
	 *
	 * @param 	array 	$where 	删除条件
	 * @param 	object 	$model 	事例对象
	 * @return 	array
	 */
	public static function destroyData($where,$model)
	{
		return $model->where($where)->delete();
	}
}