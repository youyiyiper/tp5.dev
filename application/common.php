<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function PR ($arr)
{
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

/**
 * 设置session
 * 
 * @param [type] $key   [description]
 * @param [type] $value [description]
 */
function set_session ($key,$value)
{
	return \Session::set($key,json_encode($value));
}	

/**
 * 获取session
 * 
 * @param [type] $key   [description]
 * @param [type] $value [description]
 */
function get_session ($key)
{
	$value = \Session::get($key);
	return json_decode($value,true);
}

/**
 * 获取session 键 的值
 * 
 * @return [type] [description]
 */
function get_session_key_value ($key)
{
    $key_arr = explode('.',$key);
    $arr = get_session($key_arr[0]);
    return isset($arr[$key_arr[1]]) ? $arr[$key_arr[1]] : '';
}

/**
 * 返回数据格式化
 * 
 * @param  int    $code 状态码
 * @param  string $val  错误信息或数据
 * @return array  格式化后的数据
 */
function data_format ($code, $val = '') 
{
    $key = ($code == 0) ? 'data' : 'err';
    return array('code' => $code, $key => $val);
}

/**
 * 返回数据格式化的同时渲染session
 * 
 * @param  int    $code 状态码
 * @param  string $val  错误信息或数据
 * @return array  格式化后的数据
 */
function data_format_flash ($code,$val,$flash = 'danger')
{
	\Session::flash($flash,$val);
    return data_format($code,$val);	
}

/**
 * 获取无线级分类列表
 */
function no_limit_category ($array,$pid = 0,$level = 0)
{
    static $arr=array();
    foreach($array as $val){
        if($val['pid'] == $pid){
            $val['level'] = $level;
            $arr[]=$val;
            no_limit_category($array,$val['id'],$level+1);
        }
    }
    return $arr;
}

/**
 * 树形菜单
 */
function get_tree ($items,$id='id',$pid='pid',$son = 'child')
{
    $tree = array(); //格式化的树
    $tmpMap = array();  //临时扁平数据
     
    foreach ($items as $item) {
        $tmpMap[$item[$id]] = $item;
    }
     
    foreach ($items as $item) {
        if (isset($tmpMap[$item[$pid]])) {
            $tmpMap[$item[$pid]][$son][] = &$tmpMap[$item[$id]];
        } else {
            $tree[] = &$tmpMap[$item[$id]];
        }
    }
    unset($tmpMap);
    return $tree;
}