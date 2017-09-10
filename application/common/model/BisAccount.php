<?php

namespace app\common\model;

use think\Model;

/**
 * 商户账号模型
 */
class BisAccount extends Model
{
	// 自动完成
    protected $auto = [];
    protected $insert = ['status' => 0, 'sort' => 100];
    protected $update = [];

    // 自动维护时间戳
    protected $autoWriteTimestamp = true;


    /**
     * 根据状态值获取商户信息
     * @param  integer $status -1=>已删除, 0=>待审核, 1=>正常。默认0，取待审核列表
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