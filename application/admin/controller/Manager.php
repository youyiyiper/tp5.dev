<?php
namespace app\admin\controller;

use app\admin\controller\Common;

//管理员
class Manager extends Common
{
    public function setting()
    {
       	return $this->fetch('manager/setting');
    }

	public function create()
    {
       	return $this->fetch('admin/create');
    }    

	public function edit()
    {
       	return $this->fetch('admin/edit');
    }    
}
