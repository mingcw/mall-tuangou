<?php

namespace app\common\model;

use think\Model;

/**
 * 商户门店模型
 */
class BisLocation extends Model
{
	// 自动完成
    protected $auto = [];
    protected $insert = ['status' => 0, 'sort' => 100];
    protected $update = [];

    // 自动维护时间戳
    protected $autoWriteTimestamp = true;


    /**
     * 根据状态值获取门店信息
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
    public function getLocationByBisId($id)
    {
        $where = ['bis_id' => $id];
        $field = ['id', 'name', 'create_time', 'is_main', 'status'];
        $order = 'id desc';

        return $this->where($where)->field($field)->order($order)->paginate();
    }
}