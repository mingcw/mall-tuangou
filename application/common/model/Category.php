<?php

namespace app\common\model;

use think\Model;

/**
 * 生活服务分类模型
 */
class Category extends Common
{    
    /**
     * 获取正常的顶级分类
     * @return [type] [description]
     */
    public function getNormalTopCategory()
    {
        $where = ['parent_id' => 0, 'status' => 1];
        $field = ['id', 'name', 'sort', 'parent_id', 'create_time'];
        $order = ['sort' => 'asc', 'id' => 'desc'];

        return $this->where($where)->field($field)->order($order)->select();
    }

    /**
     * 获取未删除的分类（分页）
     * @param  integer $parent_id 父ID，默认为0
     * @return [type]             [description]
     */
    public function getCategory($parent_id = 0)
    {
        $where = ['parent_id' => $parent_id, 'status' => ['neq', -1]];
        $order = ['sort' => 'ASC', 'id' => 'DESC'];
        $field = ['id', 'name', 'sort',  'status', 'parent_id', 'create_time'];

        return $this->where($where)->field($field)->order($order)->paginate();
    }

    /**
     * 根据父ID获取正常分类
     * @return [type] [description]
     */
    public function getNormalCategoryByParentId($parent_id = 0)
    {
        $where = ['parent_id' => $parent_id, 'status' => 1];
        $order = ['sort' => 'asc', 'id' => 'desc'];
        $field = ['id', 'name', 'sort', 'parent_id', 'create_time'];

        return $this->where($where)->field($field)->order($order)->select();
    }

    /**
     * 通过ID获取分类名
     * @param  integer $id [description]
     * @return [type]             [description]
     */
    public function getCategoryNameById($id)
    {
        return $this->where(['id' => $id])->value('name');
    }

    /**
     * 获取所有未删除分类
     * @return [type] [description]
     */
    public function getAllCategory()
    {
        $where = ['status' => 1];
        $order = ['sort' => 'asc', 'id' => 'desc'];
        $field = ['id', 'name', 'parent_id'];

        return $this->where($where)->field($field)->order($order)->select();
    }

    /**
     * 无限接分类
     * @param  array   $cateArr   要递归的数组
     * @param  string  $name      子级分类在父分类数组中的 key
     * @param  integer $parent_id 父级分类ID。默认为0，表示顶级分类
     * @return array              返回多维数组
     */
    static public function unlimitedForlayer($cateArr, $name = 'child', $parent_id = 0){
        $arr = array();
        foreach($cateArr as $v){
            if($v['parent_id'] == $parent_id){
                $v[$name] = self::unlimitedForlayer($cateArr, $name, $v['id']);
                $arr[] = $v;
            }
        }
        return $arr;
    }
}