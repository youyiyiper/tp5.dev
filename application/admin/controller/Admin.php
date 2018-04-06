<?php
namespace app\admin\controller;

use app\admin\controller\Common;

//管理员
class Admin extends Common
{
    public function index()
    {
       	return $this->fetch('admin/index');
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
