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
            return data_format_flash(lang('code_error'),$validate->getError());
        }

        //检查登录
        $admin = AdminsLib::getAdminInfoByEmail($post['email']);
        if(!$admin) {
            return data_format_flash(lang('code_email_not_exists'),lang('tips_email_not_exists'));
        }
        
        //检查状态
        if ($admin->status !== AdminsLib::STATUS_VALID) {
            return data_format_flash(lang('code_status_no_valid'),lang('tips_status_no_valid'));    
        }

        //检查密码
        if (md5($post['password']) !== $admin['password']) {
            return data_format_flash(lang('code_error'),lang('tips_login_error')); 
        }

        unset($admin['password']);

        //设置session
        set_session('Admin',$admin);
        return data_format(lang('code_success'),'登录成功'); 
    }
}