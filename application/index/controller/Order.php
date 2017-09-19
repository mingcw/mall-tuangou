<?php
namespace app\index\controller;

use think\Controller;

/**
 * 订单控制器
 */
class Order extends Common
{
    /**
     * 订单处理
     * @return [type] [description]
     */
    public function index()
    {
        if(!$this->getLoginUser()){
            $this->error('请登录之后继续支付', url('user/login'));
        }

        // get参数
        $id = input('get.id', 0, 'intval');
        if(!$id){
            $this->error('非法参数，请核实后重新支付');
        }

        $count = input('get.count', 0, 'intval');
        $totalPrice = input('get.total_price', 0.00, 'intval');

        // http_referer
        if(empty($_SERVER['HTTP_REFERER'])){
            $this->error('请求来源异常，请核实后重新支付');
        }

        // 商品信息
        $field = ['id', 'name', 'image', 'current_price', 'origin_price', 'status'];
        $deal = model('Deal')->field($field)->find($id);
        if(!$deal || $deal->status != 1){
            $this->error('商品不存在');
        }

        // 入库
        $orderSn = setOrderSn();
        $user = $this->user;
        $savaData = [
            'out_trade_no' => $orderSn,
            'user_id' => $user->id,
            'username' => $user->username,
            'deal_id' => $deal->id,
            'deal_count' => $count,
            'total_price' => $totalPrice,
            'referer' => $_SERVER['HTTP_REFERER'],
        ];
        $model = model('Order');
        $reslut = $model->save($savaData);
        if($reslut === false){
            $this->error('下单失败，请重试');
        }
        $orderId = $model->where(['out_trade_no' => $orderSn])->value('id');

        $this->redirect('pay/index', ['id' => $orderId]);
    }

    /**
     * 订单确认页视图
     * @return [type] [description]
     */
    public function confirm()
    {
        if(!$this->getLoginUser()){
            $this->error('请登录之后继续支付', url('user/login'));
        }

        // get参数
        $id = input('get.id', 0, 'intval');
        if(!$id){
            $this->error('非法参数，请核实后重新支付');
        }
        $count = input('get.count', 1, 'intval');

        // 商品信息
        $field = ['id', 'name', 'image', 'current_price', 'origin_price', 'status'];
        $deal = model('Deal')->field($field)->find($id);
        if(!$deal || $deal->status != 1){
            $this->error('商品不存在');
        }
        $youhui = ($deal->origin_price - $deal->current_price) * $count; // 优惠价

        return $this->fetch('', [
            'count' => $count,
            'deal' => $deal,
            'youhui' => $youhui,
            'common_controller' => 'pay', //加载pay.css
        ]);
    }
}
