<?php
namespace app\common\validate;

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
        ['name', 'require', '商户名称不能为空'],
        ['name', 'max:60', '商户名称不能超过60个字符'],
        ['city_id', 'require', '城市ID不能为空'],
        ['city_id', 'number', '城市ID必须是数字'],
        ['se_city_id', 'require', '二级城市ID不能为空'],
        ['se_city_id', 'number', '二级城市ID必须是数字'],
        ['logo', 'require', '缩略图不能为空'],
        ['licence_logo', 'require', '营业执照不能为空'],
        ['bank_info', 'require', '银行账号不能为空'],
        ['bank_name', 'require', '开户行不能为空'],
        ['bank_user', 'require', '开户人不能为空'],
        ['faren', 'require', '法人不能为空'],
        ['faren_tel', 'require', '电话不能为空'],
        ['faren_tel', ['regex' => '\d{3,4}[\s,-]?\d{7,8}|1[3,4,5,8]\d[\s,-]?\d{4}[\s,-]?\d{4}'], '电话格式不符合'],
        ['email', 'email', '邮件格式不符合'],
    ];

    // 验证场景
    protected $scene = [
        'add'  =>  ['name','city_id', 'logo', 'bank_info', 'bank_name', 'bank_user', 'faren', 'faren_tel', 'email'],
        'status' => ['id', 'status'],
    ];
}
