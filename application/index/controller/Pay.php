<?php
namespace app\index\controller;

use think\Controller;
use wxpay\database\WxPayUnifiedOrder;
use wxpay\NativePay;
use wxpay\WxPayConfig;
use wxpay\WxPayApi;
use wxpay\WxPayNotify;

/**
 * 支付控制器
 */
class Pay extends Common
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
        
        // 订单信息
        $field = ['id', 'username', 'deal_id', 'deal_count', 'total_price', 'status', 'pay_status', 'out_trade_no'];
        $order = model('Order')->field($field)->find($id);
        if(!$order || $order->status != 1 || $order->pay_status != 0){
            $this->error('订单不存在');
        }
        if($order->username != $this->getLoginUser()->username){
            $this->error('对不起，这不是您的订单');
        }

        // 商品信息
        $field = ['id', 'name'];
        $deal = model('Deal')->field($field)->find($order->deal_id);
        
        // 生成二维码
        $input = new WxPayUnifiedOrder(); // new 统一下单输入对象
        $input->setBody($deal->name);   // 商品描述
        $input->setAttach($deal->name); //附加数据
        $input->setOutTradeNo($order->out_trade_no); //商户系统内部的订单号
        $input->setTotalFee($order->total_price * 100); // 标价金额（分为单位）
        $input->setTimeStart(date("YmdHis")); // 交易起始时间
        $input->setTimeExpire(date("YmdHis", time() + 600)); // 交易结束时间
        $input->setGoodsTag("QRCode"); // 订单优惠标记
        $input->setNotifyUrl(request()->domain() . url('wxpay/notify')); // 通知地址
        $input->setTradeType("NATIVE"); // 交易类型
        $input->setProductId($order->deal_id); // 商品ID

        $notify = new NativePay();
        $result = $notify->getPayUrl($input); // 模式二生成支付url
        $url = empty($result["code_url"]) ? '' : $result["code_url"];

        return $this->fetch('', [
            'order' => $order,
            'deal' => $deal,
            'url' => $url,
        ]);
    }

    /**
     * 支付成功视图
     * @return [type] [description]
     */
    public function paysuccess()
    {
        if(!$this->getLoginUser()){
            $this->error('对不起，您未登录', url('user/login'));
        }

        return $this->fetch();
    }
}