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

    public function welcome()
    {
    	return '<h1>欢迎来到团购后台!</h1>';
    }

    public function test()
    {
    	halt( \Map::getLngLat('天津市华苑路106号华苑城3楼(雅士道kn)') );
    }

    public function map()
    {
        return \Map::staticImage('百度大厦');
    }

    public function mail()
    {
        $mail = new \Mail;
        $ok = $mail->sendMail('2748103288@qq.com', 'mingc', '邮件来了', '<p style="color: #f60; font-weight: 700;">恭喜，邮件成功!</p>', 'C:/Users/Administrator/Desktop/body.bmp');
        var_dump($ok);
    }
}
