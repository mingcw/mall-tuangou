<?php

namespace app\common\model;

use think\Model;

/**
 * 推荐位模型
 */
class Featured extends Common
{
    /**
     * 根据类型获取推荐位信息
     * @return [type] [description]
     */
    public function getFeaturedsByType($type)
    {
        $where = ['status' => ['neq', -1]];
        $type && $where['type'] = $type;
        $field = ['id', 'title', 'image' , 'url', 'create_time', 'status'];
        $order = 'id desc';

        return $this->where($where)->field($field)->order($order)->paginate();
    }
}