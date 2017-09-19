<?php

namespace app\common\model;

use think\Model;

/**
 * 前台用户模型
 */
class User extends Common
{
	 protected $insert = ['status' => 1, 'sort' => 100];
}