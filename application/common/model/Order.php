<?php

namespace app\common\model;

use think\Model;

/**
 * 用户订单模型
 */
class Order extends Common
{
	 protected $insert = ['status' => 1, 'sort' => 100];
}