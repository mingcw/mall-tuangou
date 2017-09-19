<?php

namespace app\api\controller;

use think\Controller;
use think\Request;

/**
 * 城市接口
 */
class City extends Controller
{
    protected $model;

    /**
     * 模型初始化
     * @return [type] [description]
     */
    protected function _initialize()
    {
        $this->model = model('City');
    }

    /**
     * 异步获取子级城市，根据父ID
     *
     * @return \think\Response
     */
    public function getCitysByParentId($id = 0)
    {
        if(!$id){
            $this->error('页面不存在');
        }

        $citys = $this->model->getNormalCitysByParentId($id);
        ob_end_clean();
        $this->result($citys, 0, 'ok');
    }
}