<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\library\SidebarLib;
use think\Request;

class Sidebar extends Common
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = SidebarLib::getAllSidebar();
        $this->assign('list',no_limit_category($list));
        return $this->fetch('sidebar/index');
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $parentSidebar = SidebarLib::getOptionData();
        $this->assign('parentSidebar',no_limit_category($parentSidebar));
        return $this->fetch('sidebar/create');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $res = SidebarLib::handleAdd(input('post.'));
        if($res['code'] == lang('code_success')){
            $this->redirect('admin/sidebar/create');
        }else{
            $this->redirect('admin');
        }
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $this->assign('data',SidebarLib::getInfoById($id));
        $parentSidebar = SidebarLib::getOptionData();
        $this->assign('parentSidebar',no_limit_category($parentSidebar));        
        return $this->fetch('sidebar/edit');
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $res = SidebarLib::handleUpdate(input('post.'),$id);
        if($res['code'] == lang('code_success')){
            $this->redirect('admin/sidebar/'.$id.'/edit');
        }else{
            $this->redirect('admin/sidebar/');
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $flag = SidebarLib::deleteData(array('id' => $id),array('status' => 0));
        \Session::flash('flash_notification_message','删除成功!');
        $this->redirect('admin/sidebar/');
    }
}
