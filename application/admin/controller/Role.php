<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use think\Request;
use app\admin\library\PrivilegeLib;
use app\admin\library\RoleLib;

class Role extends Common
{
    /**
     * 显示角色列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = RoleLib::getDataLists(input('get.'));
        $this->assign('list',$list);
        return $this->fetch('role/index');
    }

    /**
     * 显示创建角色表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $list = PrivilegeLib::getDataLists();
        $this->assign('privileges',no_limit_category($list));
        return $this->fetch('role/create');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $res = RoleLib::handleAdd(input('post.'));
        if($res['code'] == lang('code_success')){
            $this->redirect('admin/role/');
        }else{
            $this->redirect('admin/role/create');
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
        $this->assign('privileges',no_limit_category($list));  
        $data = RoleLib::getInfoById($id); 
        $data['rules'] = explode(',',$data['rules']);     
        $this->assign('data',$data);        
        return $this->fetch('role/edit');
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
        $res = RoleLib::handleUpdate(input('post.'),$id);
        if($res['code'] == lang('code_success')){
            $this->redirect('/admin/role/');
        }else{
            $this->redirect('/admin/role/'.$id.'/edit');
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
        #RoleLib::destroyData(array('id' => $id),(new \app\common\model\Roles));
        #\Session::flash('flash_notification_message','删除成功!');
    }
}
