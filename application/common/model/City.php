<?php

namespace app\common\model;

use think\Model;

/**
 * 城市模型
 */
class City extends Common
{
    /**
     * 通过父ID获取正常的城市信息
     * @param  integer $parent_id [description]
     * @return [type]             [description]
     */
    public function getNormalCitysByParentId($parent_id = 0)
    {
        $where = ['status' => 1,'parent_id' => $parent_id];
        $field = ['id', 'name'];
        $order = 'id desc';

        return $this->where($where)->field($field)->order($order)->select();
    }

    /**
     * 通过ID获取城市名
     * @param  integer $id [description]
     * @return [type]      [description]
     */
     public function getCityNameById($id)
     {
        return $this->where(['id' => $id])->value('name');
     }

     /**
     * 通过所有正常的城市信息
     * @param  integer $id [description]
     * @return [type]      [description]
     */
     public function getAllNormalCitys()
     {
        $field = ['id', 'name', 'is_main', 'parent_id'];
        return $this->where(['status' => 1])->field($field)->select();
     }     
}
