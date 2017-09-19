<?php
namespace app\bis\controller;
use think\Controller;

/**
 * 商户中心控制器
 */
class Index extends Common
{
    /**
     * 商户中心首页
     * @return [type] [description]
     */
    public function index()
    {
        return $this->fetch();
    }

    public function welcome()
    {
    	return '<h2>' . config('web.web_name') . '商户中心欢迎您！</h2>';
    }
}
