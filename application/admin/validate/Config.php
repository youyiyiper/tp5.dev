<?php

namespace app\admin\validate;

use think\Validate;

class Config extends Validate
{
    protected $rule = [
        'name'         => 'require|unique:configs',
        'title'         => 'require',
        'content'         => 'require',
    ];

    protected $message = [
        'name.require'      => '请输入标识',
        'name.unique'      => '标识必须唯一',
        'title.require'      => '请输入名称',
        'content.require'      => '请输入内容',
    ];
}