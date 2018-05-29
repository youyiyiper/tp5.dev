<?php

namespace app\admin\validate;

use think\Validate;

class Role extends Validate
{
    protected $rule = [
        'add_name'         => 'require|unique:roles,name',
        'edit_name'         => 'require|unique:roles,name',
    ];

    protected $message = [
        'name.require'      => '请输入角色名称',
        'name.unique'       => '角色已存在',
    ];

    protected $scene = [
        'add'  =>  ['name'],
        'edit'  =>  ['name'],
        'delete'  =>  ['name'],
    ];
}