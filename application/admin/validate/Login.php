<?php

namespace app\admin\validate;

use think\Validate;

class Login extends Validate
{
    protected $rule = [
        'email'         => 'email',
        'password'      => 'require',
    ];

    protected $message = [
        'email.email'           => '请输入正确邮箱格式',
        'password.require'      => '请输入密码',
    ];
}