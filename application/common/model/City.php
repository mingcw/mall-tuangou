<?php

namespace app\common\model;

use think\Model;

/**
 * 城市模型
 */
class City extends Model
{
    public function getNormalCitysByParentId($parent_id = 0)
    {
    	$where = [
    		'status' => 1,
    		'parent_id' => $parent_id
    	];
    	$order = [
    		'id' => 'DESC'
    	];
        $field = ['id', 'name'];

    	return $this->where($where)->field($field)->order($order)->select();
    }
}
