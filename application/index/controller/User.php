<?php
namespace app\index\controller;

use think\Controller;

/**
 * 用户控制器
 */
class User extends Controller
{
    /**
     * 登录视图
     * @return [type] [description]
     */
    public function login()
    {
        return $this->fetch();
    }

    /**
     * 注册视图
     * @return [type] [description]
     */
    public function register()
    {
        return $this->fetch();
    }
}
