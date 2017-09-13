<?php
namespace app\common\validate;

use think\Validate;

/**
 * 推荐位验证器
 */
class Featured extends Validate
{
    // 验证规则
    protected $rule = [
        ['id', 'require', 'ID不能为空'],
        ['id', 'number', 'ID必须是数字'],
        ['title', 'require', '标题不能为空'],
        ['title', 'max:30', '标题不能超过30个字符'],
        ['image', 'require', '推荐图不能为空'],
        ['image', 'max:255', '推荐图路径长不能超过255个字符'],
        ['type', 'require', '推荐位类型不能为空'],
        ['type', 'number', '推荐位类型值必须是数字'],
        ['url', 'require', 'URL不能为空'],
        ['url', 'max:255', 'URL路径长不能超过255个字符'],
        ['description', 'require', '描述不能为空'],
        ['description', 'max:255', '描述内容不能超过255个字符'],
    ];

    // 验证场景
    protected $scene = [
        'add'  =>  ['title', 'image', 'type', 'url', 'description'],
        'edit' => ['title', 'image', 'type', 'url', 'description'],
        'status'  =>  ['id', 'status'],
    ];
}
