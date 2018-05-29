<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use think\Request;
use app\admin\library\PrivilegeLib;

class Privilege extends Common
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = PrivilegeLib::getDataLists();
        $this->assign('list',no_limit_category($list));
        return $this->fetch('privilege/index');
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $list = PrivilegeLib::getDataLists();       
        $this->assign('list',no_limit_category($list));
        return $this->fetch('privilege/create');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $res = PrivilegeLib::handleAdd(input('post.'));
        if($res['code'] == lang('code_success')){
            $this->redirect('admin/privilege/');
        }else{
            $this->redirect('admin/privilege/create');
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
        $list = PrivilegeLib::getDataLists();    
        $this->assign('list',no_limit_category($list));
        $this->assign('data',PrivilegeLib::getInfoById($id));
        return $this->fetch('privilege/edit');
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
        $res = PrivilegeLib::handleUpdate(input('post.'),$id);
        if($res['code'] == lang('code_success')){
            $this->redirect('admin/privilege/');
        }else{
            $this->redirect('admin/privilege/'.$id.'/edit');
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
        PrivilegeLib::destroyData(array('id' => $id),(new \app\common\model\Privileges));
        \Session::flash('flash_notification_message','删除成功!');
        $this->redirect('admin/privilege/');
    }
}
