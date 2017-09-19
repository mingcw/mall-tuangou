<?php
namespace app\common\validate;

use think\Validate;

/**
 * 商户账号验证器
 */
class BisAccount extends Validate
{
    // 验证规则
    protected $rule = [
        ['username', 'require', '用户名不能为空'],
        ['username', 'max:16', '用户名不能超过16位字符'],
        ['password', 'require', '密码不能为空'],
        ['password', 'regex:[_a-zA-Z]\w{4,15}', '密码由5-16位数字、字母、下划线构成，首字符不能是数字'],
    ];

    // 验证场景
    protected $scene = [
        'add'  =>  ['username','password'],
        'login' => ['username', 'password'],
    ];
}
