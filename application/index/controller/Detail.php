<?php
namespace app\index\controller;

use think\Controller;

/**
 * 详情页控制器
 */
class Detail extends Common
{
    /**
     * 详情页视图
     * @return [type] [description]
     */
    public function index()
    {
        $id = input('get.id', 0, 'intval');

        // 团购商品
        $field = ['sort', 'update_time'];
        $deal = model('Deal')->field($field, true)->find($id);
        if(!$deal || $deal->status != 1){
            $this->error('页面不存在');
        }

        // 所属分类
        $field = ['id', 'name'];
        $category = model('Category')->field($field)->find($deal->category_id);

        // 所属门店
        $location = model('BisLocation')->getLocationByIds($deal->location_ids);

        // 距离开始时间多久：x年x月x日x时x分x秒
        $timeHtml = remainTime($deal->start_time);
        $keYiQiangGou = $timeHtml ? 0 : 1;

        // 剩余数
        $overplus = $deal->total_count-$deal->sell_count;

        // 所在经纬度
        $lnglat = $deal->x_point . ',' . $deal->y_point;

        return $this->fetch('', [
            'deal' => $deal,
            'category' => $category,
            'location' => $location,
            'timeHtml' => $timeHtml,
            'keYiQiangGou' => $keYiQiangGou,
            'overplus' => $overplus,
            'lnglat' => $lnglat,
            'common_title' => $deal->name,
            ''
        ]);
    }
    
}
