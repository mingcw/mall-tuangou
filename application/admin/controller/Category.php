<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

/**
 * 主平台分类管理控制器
 */
class Category extends Controller
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
     * 显示分类列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $id = input('id', 0, 'intval');
        $data = $this->model->getCategory($id);

        return $this->fetch('', ['data' => $data]);
    }

    /**
     * 显示分类表单添加页
     *
     * @return \think\Response
     */
    public function create()
    {
        $data = $this->model->getNormalTopCategory();
        
        return $this->fetch('', ['data' => $data]);
    }

    /**
     * 保存新建的分类
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = input('post.');

        $validate = validate('Category');
        if(!$validate->scene('create')->check($data)){
            $this->error($validate->getError());
        }

        if($this->model->save($data)){
            $this->success('添加成功');
        }
        else{
            $this->error('添加失败，请重试...');
        }
    }

    /**
     * 显示编辑分类表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        if(($id = intval($id)) < 1){
            $this->error('页面不存在');
        }
        
        $field = ['id', 'name', 'parent_id'];
        $thisCategory = $this->model->field($field)->find($id);
        $data = $this->model->getNormalTopCategory();

        $this->assign('thisCategory', $thisCategory);
        $this->assign('data', $data);
        return $this->fetch();
    }

    /**
     * 保存更新的分类
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        if(!$request->isPost()){
            $this->error('页面不存在');
        }

        $data = input('post.');

        $validate = validate('Category');
        if(!$validate->scene('edit')->check($data)){
            $this->error($validate->getError());
        }

        if($this->model->save($data, ['id' => $id])){
            $this->success('修改成功');
        }
        else{
            $this->error('修改失败，请重试...');
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

    /**
     * 修改状态值
     * @return [type] [description]
     */
    public function status()
    {
        $data = input('get.');

        // 数据验证
        $validate = validate('Category');
        if(!$validate->scene('status')->check($data)){
            $this->error($validate->getError());
        }

        $msg = ($data['status'] == -1 ) ? '删除' : '状态修改';
        $result = $this->model->save(['status' => (int)$data['status']], ['id' => $data['id']]);
        if($result === false){
            $this->error($msg . '失败，请重试');
        }
        else{
            $this->success($msg . '成功');
        }
    }
}
