<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\library\LoginLib;
use think\Request;

class Login extends Controller
{
	/**
	 * 登录页面
	 */
    public function index(Request $request)
    {
    	$type = $request->param('type');
    	$type = $type == 1 ? 1 : '';
       	return $this->fetch('/login'.$type);
    }

    /**
     * 执行登录操作
     */
    public function doLogin(Request $request)
    {
    	if (!$request->isPost()) {
    		$this->redirect('Login/index');
    	}else{
            $res = LoginLib::handleLogin(input('post.'));
            if($res['code'] == lang('code_success')){
                $this->redirect('Index/index');
            }else{
                $this->redirect('Login/index');
            }            
        }
    }
}
