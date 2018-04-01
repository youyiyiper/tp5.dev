<?php
namespace app\admin\controller;

use think\Controller;

class Admin extends Controller
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
