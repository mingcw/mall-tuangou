<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

/**
 * 主平台分类管理控制器
 */
class Category extends Common
{
    protected $model;

    /**
     * 模型初始化
     * @return [type] [description]
     */
    protected function _initialize()
    {
        $this->model = model('Category');
    }

    /**
     * 所有分类
     * @return [type] [description]
     */
    public function index()
    {
        $id = input('id', 0, 'intval');
        $data = $this->model->getCategory($id);

        return $this->fetch('', ['data' => $data]);
    }

    /**
     * 添加分类
     * @return [type] [description]
     */
    public function add()
    {
        if(request()->isPost()){ // 处理表单
            $data = input('post.');

            $validate = validate('Category');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }

            $result = $this->model->save($data);
            if($result === false){
                $this->error('添加失败，请重试...');
            }

            $this->success('添加成功');
        }
        else{ // 显示页面
            $data = $this->model->getNormalTopCategory();
            return $this->fetch('', ['data' => $data]);
        }
    }

    /**
     * 编辑分类
     * @return [type] [description]
     */
    public function edit()
    {
        if(request()->isPost()){ // 处理表单
            $data = input('post.');

            $validate = validate('Category');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }

            $result = $this->model->save($data, ['id' => $data['id']]);
            if($result == false){
                $this->error('修改失败，请重试...');
            }

            $this->success('修改成功');
        }
        else{ // 显示页面
            if(!$id = input('get.id', 0, 'intval')){
                $this->error('页面不存在');
            }
            
            $field = ['id', 'name', 'parent_id'];
            $thisCategory = $this->model->field($field)->find($id);
            $data = $this->model->getNormalTopCategory();

            $this->assign('thisCategory', $thisCategory);
            $this->assign('data', $data);
            return $this->fetch();
        }
    }

    /**
    * 异步更新排序
    * @return [type] [description]
    */
    public function sort(Request $request, $id)
    {
        $data = input('post.');

        $validate = validate('Category');
        if(!$validate->scene('sort')->check($data)){
            $this->error($validate->getError());
        }

        ob_end_clean();
        if($this->model->save(['sort' => $data['sort']], ['id' => $id])){
            $this->result($_SERVER['HTTP_REFERER'], 0, '修改成功'); // 成功，code 为 0
        }
        else{
            $this->result($_SERVER['HTTP_REFERER'], 1, '修改失败'); // 失败，code 为 1
        }
    }
}
