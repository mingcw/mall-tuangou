<?php
namespace app\index\controller;

use think\Controller;

/**
 * 前台地图业务控制器
 */
class Map extends Controller
{
    /**
     * 获取静态地图图片
     * @return [type] [description]
     */
    public function getMapImage()
    {
        return \Map::staticImage(input('get.lnglat', '', 'trim'));
    }
}
