<?php
namespace app\admin\controller;

use think\Controller;

//共有模块
class Common extends Controller
{
	public function initialize(){
		$admin = get_session('Admin');
		if(empty($admin)){
			$this->redirect('Login/index');exit();
		}

		$this->assign('admin',$admin);

		// 模板变量赋值
        $this->assign('adminMenus',getAdminMenus($admin['role_id']));
	}
}