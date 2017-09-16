<?php

namespace app\common\model;

use think\Model;

/**
 * 团购商品模型
 */
class Deal extends Common
{
	/**
	* 根据商户ID获取团购商品信息（分页）
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
     * 通过where条件获取正常的商品信息（分页）
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
     * 通过状态值获取商品信息（分页）
     * @return [type] [description]
     */
    public function getDealsByStatus($status = 0)
    {
        $where = ['status' => $status];
        $order = 'id desc';
        $field = ['id', 'name', 'category_id', 'city_id', 'sell_count', 'start_time', 'end_time', 'create_time', 'status'];
        return $this->where($where)->field($field)->order($order)->paginate();
    }

    /**
     * 根据分类、城市ID获取团购商品信息（分页）
     * @param  [type]  $categoryIds [description]
     * @param  [type]  $cityId      [description]
     * @param  integer $limit       [description]
     * @return [type]               [description]
     */
    public function getDealByCategoryCityId($categoryIds, $cityId, $limit = 10){
        $where = [
            'end_time' => ['gt', time()],
            'category_id' => $categoryIds,
            'city_id' => $cityId,
            'status' => 1,
        ];
        $field = ['sort', 'update_time', 'status'];
        $order = ['sort' => 'asc', 'id' => 'desc'];

        return $this->where($where)->field($field, true)->order($order)->limit($limit)->select();
    }

    /**
     * 根据条件获取团购商品信息
     * @param  [type] $cateId 所属分类ID数组 'xxx' => id，是一个where条件
     * @param  [type] $sort   排序类型
     * @return [type]         [description]
     */
    public function getDealByConditions($cateId = [], $sort)
    {
        // 组装排序条件 $order
        if(!empty($sort['sort_sale'])){
            $order['sell_count'] = 'desc';
        }
        else if(!empty($sort['sort_price'])){
            $order['current_price'] = 'desc';
        }
        else if(!empty($sort['sort_time'])){
            $order['create_time'] = 'desc';
        }
        $order['id'] = 'desc';

        $field = ['sort', 'update_time', 'status'];
        return $this->where($cateId)->field($field, true)->order($order)->paginate();
    }
}