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
     * @param  [type] $where  where条件数组型
     * @param  [type] $sort   排序类型
     * @return [type]         [description]
     */
    public function getDealByConditions($where = [], $sort)
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

        // 组装 where 条件
        // 
        // 提示: MySQL 函数 find_in_set(str, field)
        // 这个函数可以作为一个where条件查找field字段里含有str的记录,
        // field字段值由逗号","分割。比like查询更加精确
        // 
        // 这里表中的 se_category_id 字段是一个逗号","连接的ID串
        // 所以Think里 se_category_id = $id 的条件查不到有多个子分类的商品

        // 结合 find_in_set 来组装where条件字符串
        $whereStr = '';
        $whereStr .= 'status  = 1 and end_time > ' . time();
        if(!empty($where['se_category_id'])){
            $whereStr .= ' and find_in_set(' . $where['se_category_id'] . ', se_category_id)';
        }
        if(!empty($where['city_id'])){
            $whereStr .= ' and city_id = ' . $where['city_id'];
        }

        $field = ['sort', 'update_time', 'status'];
        return $this->where($whereStr)->field($field, true)->order($order)->paginate();
    }
}