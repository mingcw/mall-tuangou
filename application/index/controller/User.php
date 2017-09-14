<?php
namespace app\index\controller;

use think\Controller;

/**
 * 前台用户控制器
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
        if(request()->isPost()){
            $data = input('post.');
            if(!captcha_check())
        }
        else{
             return $this->fetch();
        }
    }

    public function captcha()
    {
        $src = captcha_src()
    }
}
