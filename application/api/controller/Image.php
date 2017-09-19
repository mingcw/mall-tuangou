<?php
namespace app\api\controller;

use think\Controller;
use think\Request;

/**
 * 图片处理接口
 */
class Image extends Controller
{
    /**
     * 上传处理
     * @return [type] [description]
     */
    public function upload()
    {
        // 获取表单上传文件
        $file = request()->file('Filedata');
        
        // 移动到框架应用根目录/public/uploads/ 目录下
        $dir = ROOT_PATH .'public' . DS . 'uploads';
        $info = $file->validate(['size' => 2*1024*1024, 'ext' => 'jpg,jpeg,png,gif'])->move($dir); // 最大2M，重命名为md5值

        ob_end_clean();
        if($info){
            $this->result('/uploads/' . str_replace('\\', '/', $info->getSavename()), 0, 'ok');
        }else{
            $this->result($file->getError(), 1, 'failed');
        }
    }
}