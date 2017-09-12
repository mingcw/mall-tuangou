<?php

namespace app\common\model;

use think\Model;

/**
 * 团购商品模型
 */
class Deal extends Common
{
	/**
	* 根据商户ID获取团购商品信息
	* @return [type]          [description]
	*/
    public function getDealByBisId($bisID)
    {
        $where = ['bis_id' => $bisID];
        $field = ['id', 'name', 'start_time', 'end_time', 'status', 'create_time'];
        $order = 'id desc';

        return $this->where($where)->field($field)->order($order)->paginate();
    }

    /**
     * 通过商品ID获取所属门店信息
     * @param  [type] $dealId [description]
     * @return [type]         [description]
     */
    public function getLocationsByDealId($dealId)
    {
        $locationIds = $this->where(['id' => $dealId])->value('location_ids');
        if(strpos($locationIds, ',') === false){
            $locationIds = (array)$locationIds;
        }
        else{
            $locationIds = explode(',', $locationIds);
        }

        return model('BisLocation')->where(['id' => ['in', $locationIds]])->column('name');
    }

    /**
     * 通过where条件获取正常的商品信息
     * @return [type] [description]
     */
    public function getNormalDealsByWhere($where)
    {
        $where['status'] = 1;
        $order = 'id desc';
        $field = ['id', 'name', 'category_id', 'city_id', 'sell_count', 'start_time', 'end_time', 'create_time', 'status'];
        return $this->where($where)->field($field)->order($order)->paginate();
    }

    /**
     * 通过状态值获取商品信息
     * @return [type] [description]
     */
    public function getDealsByStatus($status = 0)
    {
        $where = ['status' => $status];
        $order = 'id desc';
        $field = ['id', 'name', 'category_id', 'city_id', 'sell_count', 'start_time', 'end_time', 'create_time', 'status'];
        return $this->where($where)->field($field)->order($order)->paginate();
    }
}