<?php
namespace app\common\validate;

use think\Validate;

/**
 * 前台用户验证器
 */
class User extends Validate
{
	// 验证规则
    protected $rule = [
    	['username', 'require', '用户名不能为空'],
    	['username', 'max:20', '用户名不能超过20个字符'],
    	['email', 'require', '邮箱不能为空'],
    	['email',  'email', '邮件格式不符'],
        ['password', 'require', '密码不能为空'],
    	['password', 'regex:[_a-zA-Z]\w{4,15}', '密码由5-16位数字、字母、下划线构成，首字符不能是数字'],
    	['password2', 'require', '确认密码不能为空'],
        ['password2', 'confirm:password', '两次密码不一致'],
    	['mobile', ['regex' => '\d{3,4}[\s,-]?\d{7,8}|1[3,4,5,8]\d[\s,-]?\d{4}[\s,-]?\d{4}'], '电话格式不符'],
    ];

    // 验证场景
    protected $scene = [
        'register'  =>  ['username', 'email', 'password', 'password2'],
        'login'  =>  ['username', 'password'],
    ];
}