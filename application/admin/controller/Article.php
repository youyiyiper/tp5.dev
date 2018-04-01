<?php
namespace app\admin\controller;

use think\Controller;

class Article extends Controller
{
    public function index()
    {
       	return $this->fetch('article/index');
    }

	public function create()
    {
       	return $this->fetch('article/create');
    }    

	public function edit()
    {
       	return $this->fetch('article/edit');
    }    
}
