<?php
namespace app\index\controller;

use think\Controller;

/**
 * 前台首页控制器
 */
class Index extends Common
{
    /**
     * 首页视图
     * @return [type] [description]
     */
    public function index()
    {
    	// 推荐位
    	$main = model('Featured')->getFeatured(1); // 大图推荐位
    	$side = model('Featured')->getFeatured(2)[0]; // 右侧广告位

        return $this->fetch('', [
        	'main' => $main,
        	'side' => $side,
        ]);
    }
}
