<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\library\AdminLib;
use app\admin\library\RoleLib;
use think\Request;


class Admin extends Common
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = AdminLib::getDataLists(input('get.'));
        $this->assign('list',$list);
        return $this->fetch('admin/index');
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $this->assign('roleList',RoleLib::getOptionData());
        return $this->fetch('admin/create');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $res = AdminLib::handleAdd(input('post.'));
        if ($res['code'] == lang('code_success')) {
            $this->redirect('/admin/admin/create');
        } else {
            $this->redirect('/admin/admin/');
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
        $this->assign('data',AdminLib::getInfoById($id));
        $this->assign('roleList',RoleLib::getOptionData());
        return $this->fetch('admin/edit');
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
        $res = AdminLib::handleUpdate(input('post.'),$id);
        if ($res['code'] == lang('code_success')) {
            $this->redirect('/admin/admin/'.$id.'/edit');
        } else {
            $this->redirect('/admin/admin/');
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
        $flag = AdminLib::updateData(array('id' => $id),array('status' => 0));
        \Session::flash('flash_notification_message','删除成功!');
        $this->redirect('/admin/admin/');
    }
}
