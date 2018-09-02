<?php
namespace app\admin\controller;

use app\admin\controller\Common;

/**
 * 文章
 */
class Article extends Common
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
