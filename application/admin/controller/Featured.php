<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

/**
 * 推荐位管理控制器
 */
class Featured extends Common
{
    protected $model;

    /**
     * 模型初始化
     * @return [type] [description]
     */
    protected function _initialize()
    {
        $this->model = model('Featured');
    }

    /**
     * 推荐位列表
     * @return [type] [description]
     */
    public function index()
    {
        // 提取搜索类型
        $type = input('get.type', 0, 'intval');
       
        // 可供搜索的所有类型
        $typeArr = config('featured.featured_type');

        // 推荐位
        $featureds = $this->model->getFeaturedsByType($type);

        return $this->fetch('', [
            'type' => $type,
            'typeArr' => $typeArr,
            'featureds' => $featureds,
        ]);
    }

    /**
     * 添加推荐位
     * @return [type] [description]
     */
    public function add()
    {
        if(request()->isPost()){ // 处理表单
            $data = input('post.');

            $validate = validate('Featured');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }

            $result = $this->model->save($data);
            if($result === false){
                $this->error('添加失败，请重试');
            }
            $this->success('添加成功');
        }
        else{ // 显示页面
            $type = config('featured.featured_type'); // 推荐位类型（在前台页面的位置标识）
            return $this->fetch('', ['type' => $type]);
        }
    }

    /**
     * 编辑推荐位
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit()
    {
        if(request()->isPost()){ // 处理表单
            $data = input('post.');

            $validate = validate('Featured');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }

            $result = $this->model->save($data, ['id' => $data['id']]);
            if($result === false){
                $this->error('修改失败，请重试...');
            }

            $this->success('修改成功', url('featured/index'));
        }
        else{ // 显示页面
            if(!$id = input('get.id', 0, 'intval')){
                $this->error('页面不存在');
            }
            
            $field = ['id', 'type', 'title', 'image' , 'url', 'description'];
            $featured = $this->model->field($field)->find($id);

            $type = config('featured.featured_type'); // 推荐位类型（在前台页面的位置标识）

            return $this->fetch('', [
                'featured' => $featured,
                'type' => $type,
            ]);
        }
    }
}