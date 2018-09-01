<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\library\LoginLib;
use app\admin\library\EmailLib;
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
    		return $this->redirect('Login/index');
    	}

        $res = LoginLib::handleLogin(input('post.'));
        if($res['code'] == lang('code_success')){
            return $this->redirect('Index/index');
        }else{
            return $this->redirect('Login/index');
        }            
    }

    /**
     * 通过邮箱 修改密码
     * 
     * @return [type] [description]
     */
    public function email(Request $request)
    {
        return $this->fetch('auth/email');
    }

    /**
     * 通过邮箱 修改密码
     * 
     * @return [type] [description]
     */
    public function doEmail(Request $request)
    {
        if (!$request->isPost()) {
            return $this->redirect('Login/email');
        }

        $res = EmailLib::handleEmail(input('post.'));
        if ($res['code'] == lang('code_success')) {
            return $this->redirect('Index/index');
        } else {
            return $this->redirect('Login/email');
        }            
    }

    /**
     * 验证邮箱密码
     * 
     * @return [type] [description]
     */
    public function validEmail(Request $request)
    {
        if (!$request->code) {
            return $this->redirect('Login/email');
        }
        
        $res = EmailLib::validEmail($request->code);
        if ($res['code'] == lang('code_success')) {
            //修改密码页面
            return $this->redirect('Login/reset');
        } else {
            return $this->redirect('Login/email');
        }        
    }

    /**
     * 重置密码
     */
    public function reset(Request $request)
    {
        return $this->fetch('auth/reset');
    }

    /**
     * 重置密码
     */
    public function doReset(Request $request)
    {
        if (!$request->isPost()) {
            return $this->redirect('Login/email');
        }

        $res = EmailLib::handleResetPwd(input('post.'));
        if ($res['code'] == lang('code_success')) {
            return $this->redirect('Login/index');
        } else {
            return $this->redirect('Login/email');
        }        
    }        
}
