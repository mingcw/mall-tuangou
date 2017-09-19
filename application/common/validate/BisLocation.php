<?php
namespace app\common\validate;

use think\Validate;

/**
 * 商户门店验证器
 */
class BisLocation extends Validate
{
    // 验证规则
    protected $rule = [
        ['tel', 'require', '电话不能为空'],
        ['tel', ['regex' => '\d{3,4}[\s,-]?\d{7,8}|1[3,4,5,8]\d[\s,-]?\d{4}[\s,-]?\d{4}'], '电话号码有误'],
        ['contact', 'require', '联系人不能为空'],
        ['contact', 'max:16', '联系人长度不能超过16个字符'],
        ['address', 'require', '地址不能为空'],
        ['address', 'max:255', '地址长度不能超过255个字符'],
        ['open_time', 'require', '营业时间不能为空'],
        ['category_id', 'number', '分类ID必须是数字'],
        ['se_category_id', 'number', '二级分类ID必须是数字'],
        ['category_id', 'number', '分类ID必须是数字'],
        ['status', 'number', '状态值必须是数字']
    ];

    // 验证场景
    protected $scene = [
        'add'  =>  ['tel','contact', 'address'],
        'status' => ['status'],
    ];
}
