<?php
namespace app\admin\validate;

use think\Validate;

/**
 * 分类验证器
 */
class Category extends Validate
{
    // 验证规则
    protected $rule = [
        ['name', 'require', '分类名不能为空'],
        ['name', 'checkName:', '分类名不能为空白字符'],
        ['name', 'max:10', '分类名不能超过10个中/英文字符'],
        ['parent_id', 'number', '父ID必须是数字'],
        ['id', 'number'],
        ['status', 'number', '状态值必须是数字'],
        ['status', 'in:-1,0,1', '状态值不合法'],
        ['sort', 'number']
    ];

    // 验证场景
    protected $scene = [
        'create'  =>  ['name','parent_id'],
        'edit' => ['id', 'name', 'parent_id'], 
        'sort' => ['id', 'sort'],
        'status' => ['id', 'status']
    ];


    // 自定义验证规则
    protected function checkName($value, $rule, $data)
    {
        return trim($value) ? true : false;
    }

}
