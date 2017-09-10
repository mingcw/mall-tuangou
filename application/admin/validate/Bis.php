<?php
namespace app\admin\validate;

use think\Validate;

/**
 * 商户验证器
 */
class Bis extends Validate
{
	// 验证规则
    protected $rule = [
        ['id', 'number', 'ID必须是数字'],
	    ['status', 'number', '状态值必须是数字'],
    ];

    // 验证场景
    protected $scene = [
        'status' => ['id', 'status'],
    ];
}
