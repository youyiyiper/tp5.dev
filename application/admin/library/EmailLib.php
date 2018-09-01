<?php
namespace app\admin\library;

use app\admin\library\AdminLib;
use app\common\model\EmailValid;

class EmailLib
{
	/**
	 * 处理后台email
	 * 
	 * @param  [type] $post 表单信息
	 * @return [type]       [description]
	 */
    public static function handleEmail($post)
    {
        if(empty($post['email'])){
        	return data_format_flash(lang('code_param_must'),lang('tips_param_must'));
        }

        if(!is_email($post['email'])){
        	return data_format_flash(lang('code_param_must'),lang('tips_param_must'));
        }

        //检查登录
        $admin = AdminLib::getAdminInfoByEmail($post['email']);
        if (!$admin) {
            return data_format_flash(lang('code_email_not_exists'),lang('tips_email_not_exists'));
        }
        
        //检查状态
        if ($admin->status !== AdminLib::STATUS_VALID) {
            return data_format_flash(lang('code_status_no_valid'),lang('tips_status_no_valid'));    
        }

        $data = [
        	'email' => $post['email'],
        	'validcode' => md5($post['email'].uniqid()),
    	];
        $email = [
        	'subject' => '修改密码',
        	'fromname' => '修改密码',
        	'email' => $post['email'],
        	'content' => $_SERVER['HTTP_HOST'].'/admin/validEmail?code='.base64_encode(json_encode($data)),
        ];

        //发送邮件
        if(self::_sendEmail($email)){
        	//将邮箱和验证密码入库
			$data['created_at'] = $data['updated_at'] = date('Y-m-d H:i:s');
			$data['out_time'] = time()+600;
			(new EmailValid)->save($data);        	
			return data_format_flash(lang('code_success'),lang('tips_email_send_success'),'success');
        }else{
        	return data_format_flash(lang('code_error'),lang('tips_email_send_fail'));
        }
    }

    /**
	 * 发送邮箱
	 * 
	 * @param type $data 邮箱队列数据 包含邮箱地址 内容
	 */
	public static function _sendEmail($data = []) 
	{
		$mail = new \phpmailer\phpmailer(); //实例化
		$mail->IsSMTP(); // 启用SMTP
		$mail->Host = 'smtp.126.com'; //SMTP服务器 以126邮箱为例子 
		$mail->Port = 465;  //邮件发送端口
		$mail->SMTPAuth = true;  //启用SMTP认证
		$mail->SMTPSecure = "ssl";   // 设置安全验证方式为ssl
		$mail->CharSet = "UTF-8"; //字符集
		$mail->Encoding = "base64"; //编码方式
		$mail->Username = 'xxxx@126.com';  //你的邮箱 
		$mail->Password = 'xxxx';  //你的密码 
		$mail->Subject = $data['subject']; //邮件标题  
		$mail->From = 'xxxx@126.com';  //发件人地址（也就是你的邮箱）
		$mail->FromName = $data['fromname'];  //发件人姓名
		$mail->AddAddress($data['email'], "亲"); //添加收件人（地址，昵称）
		$mail->IsHTML(true); //支持html格式内容
		$mail->Body = $data['content']; //邮件主体内容
		//发送成功就删除
		if ($mail->Send()) {
			return true;
		}else{
			return false;//"Mailer Error: ".$mail->ErrorInfo;// 输出错误信息  
		}       
	}

	/**
	 * 验证邮箱
	 * 
	 * @return [type] [description]
	 */
	public static function validEmail($code)
	{
		$data = json_decode(base64_decode($code),true); 
		if (!isset($data['validcode']) || !isset($data['email'])) {
			return data_format_flash(lang('code_param_must'),lang('tips_param_must'));
		}

		//获取数据
		$res = EmailValid::where('email', $data['email'])->where('validcode', $data['validcode'])->order('created_at','desc')->findOrFail();
		if(!$res){
			return data_format_flash(lang('code_error'),lang('code_email_not_exists'));
		}

		//是否过期
		if($res->out_time > time()){
			//将邮箱写入session
			\Session::set('validEmail',$data['email']);
			return data_format_flash(lang('code_success'),lang('tips_valid_success'),'success');
		}else{
			return data_format_flash(lang('code_error'),lang('tips_email_out_time'));
		}
	}

	/**
	 * 重置密码
	 * 
	 * @param  [type] $post 表单信息
	 * @return [type]       [description]
	 */
    public static function handleResetPwd($post)
    {
        if(empty($post['email']) || empty($post['password']) || empty($post['password_confirmation'])){
        	return data_format_flash(lang('code_param_must'),lang('tips_param_must'));
        }

        if(!is_email($post['email'])){
        	return data_format_flash(lang('code_param_must'),lang('tips_param_must'));
        }

        if($post['password'] !== $post['password_confirmation']){
        	return data_format_flash(lang('code_param_must'),lang('tips_param_must'));
        }

		if($post['email'] !== \Session::get('validEmail')){
        	return data_format_flash(lang('code_email_not_exists'),lang('tips_email_not_exists'));
        }        

        //检查登录
        $admin = AdminLib::getAdminInfoByEmail($post['email']);
        if (!$admin) {
            return data_format_flash(lang('code_email_not_exists'),lang('tips_email_not_exists'));
        }

        $flag = AdminLib::updateData(array('email' => $post['email']),array('password' => md5($post['password'])));
        if($flag){
        	\Session::delete('validEmail');
			return data_format_flash(lang('code_success'),lang('tips_valid_success'),'success');
        }else{
        	return data_format_flash(lang('code_error'),lang('tips_error'));
        }
    }	
}