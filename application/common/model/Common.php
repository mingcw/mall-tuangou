<?php

namespace app\common\model;

use think\Model;

/**
 * 基类公共模型
 */
class Common extends Model
{
    // 自动完成
    protected $auto = [];
    protected $insert = ['status' => 0, 'sort' => 100];
    protected $update = [];

    // 自动维护时间戳
    protected $autoWriteTimestamp = true;
}