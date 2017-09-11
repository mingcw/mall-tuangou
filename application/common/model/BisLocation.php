<?php

namespace app\common\model;

use think\Model;

/**
 * 商户门店模型
 */
class BisLocation extends Common
{
    /**
     * 根据商户ID获取正常的门店信息
     * @param  [type] $bisId [description]
     * @return [type]        [description]
     */
    public function getNormalLocatinByBisId($bisId)
    {
        $where = ['bis_id' => $bisId , 'status' => 1];
        $field = ['id', 'name', 'create_time', 'is_main', 'status'];
        $order = 'id desc';

        return $this->where($where)->field($field)->order($order)->select();
    }

    /**
     * 获取门店信息
     * @param  integer $status -1=>已删除, 0=>待审核, 1=>正常。默认0，取待审核列表
     * @return [type]          [description]
     */
    public function getLocationByStatus($status = 0)
    {
        $where = ['status' => $status];
        $field = ['id', 'name', 'create_time', 'is_main', 'status'];
        $order = 'id desc';

        return $this->where($where)->field($field)->order($order)->paginate();
    }

    /**
     * 根据商户ID获取门店信息
     * @return [type]          [description]
     */
    public function getLocationByBisId($bisID)
    {
        $where = ['bis_id' => $bisID];
        $field = ['id', 'name', 'create_time', 'is_main', 'status'];
        $order = 'id desc';

        return $this->where($where)->field($field)->order($order)->paginate();
    }
}