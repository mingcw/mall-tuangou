<?php
namespace app\admin\controller;

use think\Controller;
use extend\Map;

/**
 * 主平台中心控制器
 */
class Index extends Controller
{
    /**
     * 主平台首页
     * @return [type] [description]
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 首页欢迎消息
     * @return [type] [description]
     */
    public function welcome()
    {
    	return $this->fetch();
    }
}
