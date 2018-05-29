<?php
namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\library\AdminLib;
use think\Request;

//管理员用户中心
class Manager extends Common
{
	/**
	 * 设置个人头像
	 */
    public function setting()
    {
        return $this->fetch('manager/setting');
    }

    /**
     * 保存头像图片
     */
    public function saveHeadimg(Request $request)
    {
        $data['headimg'] = $request->post('headimg');
        $adminSession = get_session('Admin');
        $res = AdminLib::handleUpdate($data,$adminSession['id']);
        $ret = AdminLib::getAdminInfoById($adminSession['id']);
        unset($ret['password']);
        set_session('Admin',$ret);

        return json($res);      
    }

    /**
     * 修改密码
     */
	public function changePwd()
    {
       	return $this->fetch('manager/changePwd');
    }    

    /**
     * 提交修改密码
     */
	public function postChangePwd(Request $request)
    {
    	$res = AdminLib::handleChangePwd(input('post.'));

       	if ($res['code'] == lang('code_success')) {
       		$this->redirect('manager/logout');
       	} else {
       		$this->redirect('manager/changePwd');
       	}
    }

    /**
     * 执行退出操作
     */
    public function logout()
    {
    	session(null);
    	$this->redirect('Login/index');
    }    
}
