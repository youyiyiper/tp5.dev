<?php
namespace app\admin\controller;

use think\Controller;

class Common extends Controller
{
	public function initialize(){
		// 模板变量赋值
        $this->assign('adminMenus',getAdminMenus());
	}
}