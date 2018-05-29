<?php
namespace app\admin\controller;

use think\Controller;

//共有模块
class Common extends Controller
{
	public function initialize(){
		$admin = get_session('Admin');
		if(empty($admin)){
			$this->redirect('Login/index');exit();
		}

		$this->assign('admin',$admin);

		// 模板变量赋值
        $this->assign('adminMenus',getAdminMenus($admin['role_id']));
	}

	/**
     * 头像上传
     */
    public function upload()
    {
    	// 获取表单上传文件 例如上传了001.jpg
	    $file = request()->file('img');
	    // 移动到框架应用根目录/uploads/ 目录下
	    $path = './uploads';
	    $info = $file->validate(['ext'=>'jpg,png,gif'])->move($path);
	    if ($info) {
	        // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
	        $file_path = trim($path,'.').'/'.$info->getSaveName();
	      	$imageSize = getimagesize('.'.$file_path);
	        return json([
	            'status'    => 'success',
	            'url'       => $file_path,
	            'width'     => isset($imageSize[0]) ? $imageSize[0] : 200,
	            'height'     => isset($imageSize[1]) ? $imageSize[1] : 200,
	        ]);
	    } else {
	        // 上传失败获取错误信息
	        #echo $file->getError();
	        return json([
                'status' => 'error',
                'message' => 'Server error while uploading',
            ]);
	    }
    }

    /**
     * 头像裁剪
     */
    public function handle()
    {
    	$form_data = input();
        $image_url = str_replace('\\','/',$form_data['imgUrl']);

        // resized sizes
        $imgW = $form_data['cropH'];
        $imgH = $form_data['cropW'];

        $filename_array = explode('/', $image_url);
        $filename = $filename_array[sizeof($filename_array)-1];

        $image = \think\Image::open('.'.$image_url);
        $path = str_replace($filename, '', $image_url);

        $image->crop($imgW, $imgH)
            ->save('.'.$path . 'cropped-' . $filename);

        if (!$image) {
            return json([
                'status' => 'error',
                'message' => 'Server error while uploading',
            ]);
        }

        //删除上传的图片 保留裁剪后的图片
        unlink('.' . $image_url);

        return json([
            'status' => 'success',
            'url' => $path . 'cropped-' . $filename
        ]);
    }
}