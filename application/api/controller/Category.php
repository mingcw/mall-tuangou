<?php

namespace app\api\controller;

use think\Controller;
use think\Request;

/**
 * 生活服务分类接口
 */
class Category extends Controller
{
    protected $model;

    /**
     * 模型初始化
     * @return [type] [description]
     */
    protected function _initialize()
    {
        $this->model = model('Category');
    }

    /**
     * 异步获取子级分类，根据父ID
     *
     * @return \think\Response
     */
    public function getCategoryByParentId($id = 0)
    {
        if(!$id){
            $this->error('页面不存在');
        }

        $category = $this->model->getNormalCategoryByParentId($id);
        ob_end_clean();
        $this->result($category, 0, 'ok');
    }
}