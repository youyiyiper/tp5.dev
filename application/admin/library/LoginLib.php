<?php
namespace app\admin\library;

use app\admin\library\AdminsLib;

class LoginLib
{
	/**
	 * 处理后台登录
	 * 
	 * @param  [type] $post 表单信息
	 * @return [type]       [description]
	 */
    public static function handleLogin($post)
    {
        $validate = new \app\admin\validate\Login;
        if (!$validate->check($post)) {
            return dataFormatFlash(lang('code_error'),$validate->getError());
        }

        //检查登录
        $admin = AdminsLib::getAdminInfoByEmail($post['email']);
        if(!$admin){
            return dataFormatFlash(lang('code_email_not_exists'),lang('tips_email_not_exists'));
        }
        
        //检查状态
        if($admin->status !== AdminsLib::STATUS_VALID){
            return dataFormatFlash(lang('code_status_no_valid'),lang('tips_status_no_valid'));    
        }

        //检查密码
        if(md5($post['password']) !== $admin['password']){
            return dataFormatFlash(lang('code_error'),lang('tips_login_error')); 
        }

        //设置session
        \Session::set('Admin',$admin);
        return dataFormat(lang('code_success'),'登录成功'); 
    }
}