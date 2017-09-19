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
        $model = model('Featured');
        $main = $model->getFeatured(1);    // 大图推荐位
        $side = $model->getFeatured(2)[0]; // 右侧广告位

        // 排序前2的顶级分类
        $cate = model('Category')->getCategoryByParentId(0, 2);

        // 每个顶级分类的子分类和下属商品
        $modelDeal = model('Deal');
        $modelCategory = model('Category');
        $limit = 4;
        
        foreach ($cate as $k => $v) {
             // 子分类（最多4个）
            $cate[$k]['child'] = $modelCategory->getCategoryByParentId($v->id, $limit);

            // 提取子分类ID 
            $cateIdArr = [];
            foreach ($cate[$k]['child'] as $key => $value) {
                $cateIdArr[] = $value->id;
            }
            $cateIdArr[] = $v->id; // 提取顶级ID

            // 该分类和子类的所有商品
            $cate[$k]['deal'] = $modelDeal->getDealByCategoryCityId(['in', $cateIdArr], $this->city->id);
        }

        return $this->fetch('', [
            'main' => $main,
            'side' => $side,
            'cate' => $cate,
        ]);
    }
}
