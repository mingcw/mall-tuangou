<?php
namespace app\common\validate;

use think\Validate;

/**
 * 团购商品验证器
 */
class Deal extends Validate
{
    // 验证规则
    protected $rule = [
        ['name', 'require', '团购名称不能为空'],
        ['name', 'max:50', '团购名称不能超过50个字符'],
        ['city_id', 'number', '所属城市ID必须是数字'],
        ['category_id', 'number', '分类ID必须是数字'],
        ['image', 'require', '缩略图不能为空'],
        ['start_time', 'require', '团购开始时间不能为空'],
        ['start_time', 'regex:\d{4}-\d{1,2}\-\d{1,2} {1}\d{1,2}:\d{1,2}', '团购开始时间格式不符'],
        ['end_time', 'require', '团购结束时间不能为空'],
        ['end_time', 'regex:\d{4}-\d{1,2}\-\d{1,2} {1}\d{1,2}:\d{1,2}', '团购结束时间格式不符'],
        ['total_count', 'number', '库存数必须是数字'],
        ['origin_price', 'number', '原价必须是数字'],
        ['current_price', 'number', '团购价必须是数字'],
        ['coupons_begin_time', 'require', '消费券生效时间不能为空'],
        ['coupons_begin_time', 'regex:\d{4}-\d{1,2}\-\d{1,2} {1}\d{1,2}:\d{1,2}', '消费券生效时间格式不符'],
        ['coupons_end_time', 'require', '消费券结束时间不能为空'],
        ['coupons_end_time', 'regex:\d{4}-\d{1,2}\-\d{1,2} {1}\d{1,2}:\d{1,2}', '消费券结束时间格式不符'],
        ['notes', 'require', '购买须知不能为空'],
        ['description', 'require', '团购描述不能为空']
    ];

    // 验证场景
    protected $scene = [
        'add'  =>  ['name','city_id', 'category_id', 'image',  'start_time', 'end_time', 'total_count', 'origin_price', 'current_price', 'coupons_begin_time', 'coupons_end_time', 'notes', 'description'],
        'status' => ['status'],
    ];
}
