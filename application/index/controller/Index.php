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
        $cate = model('Category')->getTopCateNumberX(2);

        // 每个顶级分类的下属商品和子级分类
        $modelDeal = model('Deal');
        $modelCategory = model('Category');
        $limit = 4;
        foreach ($cate as $k => $v) {
            $cate[$k]['deal'] = $modelDeal->getNormalDealByCategoryCityId($v->id, $this->city->id);// 下属商品
            $cate[$k]['child'] = $modelCategory->getSubCategoryByParentId($v->id, $limit); // 子级分类（4个）
        }

        return $this->fetch('', [
            'main' => $main,
            'side' => $side,
            'cate' => $cate,
        ]);
    }
}
