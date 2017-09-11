<?php

namespace app\common\model;

use think\Model;

/**
 * 商户模型
 */
class Bis extends Common
{
    /**
     * 根据状态值获取商户信息
     * @param  integer $status -1=>已删除, 0=>待审核, 1=>正常。默认0，取申请商户列表
     * @return [type]          [description]
     */
    public function getBisByStatus($status = 0)
    {
    	$where = ['status' => $status];
    	$field = ['id', 'name', 'faren', 'faren_tel', 'create_time', 'status'];
    	$order = 'id desc';

    	return $this->where($where)->field($field)->order($order)->paginate();
    }
}