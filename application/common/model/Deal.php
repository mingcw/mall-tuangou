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
}