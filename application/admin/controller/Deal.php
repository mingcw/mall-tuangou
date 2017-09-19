<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

/**
 * 团购商品管理控制器
 */
class Deal extends Controller
{

    protected $model;

    /**
     * 模型初始化
     * @return [type] [description]
     */
    protected function _initialize()
    {
        $this->model = model('Deal');
    }

    /**
     * 团购商品列表
     * @return [type] [description]
     */
    public function index()
    {
        $data = input('get.');

        // 组装where条件
        $where = [];
        if(!empty($data['start_time'])){
            $where['start_time'] = ['gt', strtotime($data['start_time'])];
        }
        if(!empty($data['end_time'])){
            $where['end_time'] = ['lt', strtotime($data['end_time'])];
        }
        if(!empty($data['category_id'])){
            $where['category_id'] = $data['category_id'];
        }
        if(!empty($data['city_id'])){
            $where['city_id'] = $data['city_id'];
        }
        if(!empty($data['name'])){
            $where['name'] = ['like', '%' . $data['name']. '%'];
        }
        $deals = $this->model->getNormalDealsByWhere($where);

        // 所有一级分类
        $categorys = model('Category')->getNormalCategoryByParentId();       
        $categoryArr = [];
        foreach($categorys as $v){
            $categoryArr[$v->id] = $v->name;
        }

        // 所有城市
        $citys = model('City')->getAllNormalCitys();
        $cityArr = [];
        foreach($citys as $v){
            $cityArr[$v->id] = $v->name;
        }

        return $this->fetch('', [
            'deals' => $deals,
            'categorys' => $categorys,            
            'citys' => $citys,   
            'category_id' => empty($data['category_id']) ? '' : $data['category_id'],  
            'city_id' => empty($data['city_id']) ? '' : $data['city_id'], 
            'start_time' =>  empty($data['start_time']) ? '' : $data['start_time'],
            'end_time' =>  empty($data['end_time']) ? '' : $data['end_time'],
            'name' =>  empty($data['name']) ? '' : $data['name'],
            'categoryArr' => $categoryArr,
            'cityArr' => $cityArr,
        ]);
    }

    /**
     * 待审核列表
     * @return [type] [description]
     */
    public function apply()
    {
        $deals = $this->model->getDealsByStatus(0); // 待审核

        // 所有一级分类
        $categorys = model('Category')->getNormalCategoryByParentId();       
        $categoryArr = [];
        foreach($categorys as $v){
            $categoryArr[$v->id] = $v->name;
        }

        // 所有城市
        $citys = model('City')->getAllNormalCitys();
        $cityArr = [];
        foreach($citys as $v){
            $cityArr[$v->id] = $v->name;
        }

        return $this->fetch('', [
            'deals' => $deals,
            'categoryArr' => $categoryArr,
            'cityArr' => $cityArr,
        ]);
    }


    /**
     * 已下架商品
     * @return [type] [description]
     */
    public function del()
    {
        $deals = $this->model->getDealsByStatus(-1); //已下架

        // 所有一级分类
        $categorys = model('Category')->getNormalCategoryByParentId();       
        $categoryArr = [];
        foreach($categorys as $v){
            $categoryArr[$v->id] = $v->name;
        }

        // 所有城市
        $citys = model('City')->getAllNormalCitys();
        $cityArr = [];
        foreach($citys as $v){
            $cityArr[$v->id] = $v->name;
        }

        return $this->fetch('', [
            'deals' => $deals,
            'categoryArr' => $categoryArr,
            'cityArr' => $cityArr,
        ]);
    }

    /**
     * 商品详情视图
     * @return [type] [description]
     */
    public function detail()
    {
        $id = input('id', 0, 'intval');
        if(!$id){
            $this->error('页面不存在');
        }

        // 商品信息
        $field = ['is_main', 'api_address', 'bis_id', 'sell_count', 'x_point', 'y_point', 'balance_price', 'sort', 'status', 'create_time', 'update_time'];
        $deal = $this->model->where(['id' => $id])->field($field, true)->find();

        // 所属城市
        $city = model('City')->getCityNameById($deal->city_id);

        // 所属一级分类
        $category = model('Category')->getCategoryNameByid($deal->category_id);

        // 所属门店
        $locations = $this->model->getLocationsByDealId($id);

        return $this->fetch('', [
            'deal' => $deal,
            'city' => $city,
            'category' => $category,
            'locations' => $locations,
        ]);
    }

    /**
     * 修改商品状态值
     * @return [type] [description]
     */
    public function status()
    {
        $data = input('get.');

        // 验证
        $validate = validate('Deal');
        if(!$validate->scene('status')->check($data)){
            $this->error($validate->getError());
        }

        // 入库
        $result =  $this->model->where(['id' => $data['id']])->update(['status' => (int)$data['status']]);
        switch ($data['status']) {
            case -1: $msg = '下架'; break;
            case  1: $msg = '上架'; break;
            default: $msg = '状态修改';
        }
        if($result === false){
            $this->error($msg . '失败，请重试');
        }

        // 邮件通知（建议走消息队列，减轻服务器压力）
        $mail = new \Mail;
        $deal = $this->model->where(['id' => $data['id']])->field(['name', 'bis_id'])->find();
        $email = model('Bis')->where(['id' => $deal->bis_id])->value('email');
        $username = model('BisAccount')->where(['bis_id' => $deal->bis_id])->value('username');
        $title = '团购商品最新状态通知';
        $statusText = dealStatus((int)$data['status']);
        $content = <<<EOF
<div style="margin: 0; padding: 16px 2em; background: #e0f3f7; color: #333;">
<p>您好，{$username}！</p>
<p>关于您的团购商品【{$deal->name}】，最新状态通知如下：</p>
<p style="color: #f00;">{$statusText}</p></div>
EOF;

        $mail->sendMail($email, $username, $title, $content);
        $this->success($msg . '成功');
    }

}