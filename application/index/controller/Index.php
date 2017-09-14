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
        return $this->fetch();
    }
}
