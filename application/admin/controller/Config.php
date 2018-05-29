<?php

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\library\ConfigLib;
use think\Request;

class Config extends Common
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = ConfigLib::getAllConfig(input('get.'));
        $this->assign('list',$list);
        return $this->fetch('config/index');
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return $this->fetch('config/create');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $res = ConfigLib::handleAdd(input('post.'));
        if($res['code'] == lang('code_success')){
            $this->redirect('/admin/config/create');
        }else{
            $this->redirect('/admin/config');
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
        $this->assign('data',ConfigLib::getInfoById($id));       
        return $this->fetch('config/edit');
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
        $res = ConfigLib::handleUpdate(input('post.'),$id);
        if($res['code'] == lang('code_success')){
            $this->redirect('/admin/config/'.$id.'/edit');
        }else{
            $this->redirect('/admin/config/');
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
        $flag = ConfigLib::destroyData(array('id' => $id),(new \app\common\model\Configs));
        \Session::flash('flash_notification_message','删除成功!');
        $this->redirect('/admin/config/');
    }
}
