<?php
namespace app\admin\controller;

use app\admin\controller\Common;

//首页
class Index extends Common
{
    public function index()
    {
       	return $this->fetch('/index');
    }
}
