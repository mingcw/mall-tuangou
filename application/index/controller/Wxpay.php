<?php
namespace app\index\controller;

use think\Controller;
use wxpay\database\WxPayResults;
use wxpay\database\WxPayUnifiedOrder;
use wxpay\NativePay;
use wxpay\WxPayConfig;
use wxpay\WxPayApi;
use wxpay\WxPayNotify;

/**
 * 微信支付控制器
 */
class Wxpay extends Common
{
    /**
     * 用户支付后，商户后台得到通知的回调接口
     * @return [type] [description]
     */
    public function notify()
    {
        // 取得微信回调过来的数据
        $wxData = file_get_contents('php://input');
        file_put_contents('/WxNotify.xml', $wxData, FILE_APPEND);

        try{
            $resultObj = new WxPayResults(); // 接口调用结果类
            $wxData = $resultObj->Init($wxData); // xml数据转为数组
        }
        catch(\Exception $e) { // 捕捉异常，返回给微信参数
            $resultObj->setData('return_code', 'FAIL');
            $resultObj->setData('return_msg', $e->getMessage());
            
            return $resultObj->toXml();
        }

        if($wxData['return_code'] === 'FAIL' || $wxData['result_code'] != 'SUCCESS'){
            $resultObj->setData('return_code', 'FAIL');
            $resultObj->setData('return_msg', 'error');
            
            return $resultObj->toXml();
        }

        // 根据out_trade_no 查询订单数据
        $outTradeNo = $wxData['out_trade_no'];
        $where = ['out_trade_no' => $outTradeNo];
        $field = ['sort', 'create_time', 'update_time'];
        $order = model('Order')->where($where)->field($field, true)->find();
        if(!$order || $order->pay_status == 1){
            $resultObj->setData('return_code', 'SUCCESS');
            $resultObj->setData('return_msg', 'ok');
            
            return $resultObj->toXml();
        }
        
        try{
            // 更新订单表
            $model = model('Order');
            $model->updateOrderByoutTradeNo($outTradeNo, $wxData);
            $where = ['out_trade_no' => $outTradeNo];
            $field = ['deal_id', 'deal_count'];
            $deal = $model->where($where)->field($field)->find();

            // 更新商品表
            model('Deal')->updateSellCountByDealId($deal->deal_id, $deal->deal_count);

            // 消费券生成
            $coupons = [
                'sn' => $outTradeNo,
                'password' => rand(10000, 99999),
                'user_id' => $order->user_id,
                'deal_id' => $order->deal_id,
                'order_id' => $order->id,
            ];
            model('Coupons')->save($coupons);

            // 邮件通知（建议走消息队列，减轻服务器压力）
            $mail = new \Mail;
            $title = '消费券发放通知';
            $username = model('User')->where(['id' => $order->user_id])->value('username');
            $webName = config('web.web_name');
            $content = <<<EOF
<div style="margin: 0; padding: 16px 2em; background: #e0f3f7; color: #333;">
<p>亲爱的用户 {$username}</p>
<p>您已获得一张$webName}的最新消费券，请在失效之前消费！</p>
<p>祝您团购愉快！</p></blockquote></div>
EOF;
        $mail->sendMail($data['email'], $data['username'], $title, $content);
        }

        catch(\Exception $e) {
            // 更新失败，返回给微信参数，继续回调
            return false;
        }

        // 成功
        $resultObj->setData('return_code', 'FAIL');
        $resultObj->setData('return_msg', 'error');
        
        return $resultObj->toXml();
    }

    /**
     * 生成微信支付二维码
     * 
     * 统一下单支付接口：微信支付-模式二扫码支付
     * 
     * 流程：
     * 1、调用统一下单，取得code_url，生成二维码
     * 2、用户扫描二维码，进行支付
     * 3、支付完成之后，微信服务器会通知支付成功
     * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
     * 
     * 统一下单详细参数：https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=9_1
     * @return [type] [description]
     */
    public function qrCode($id)
    {
        $input = new WxPayUnifiedOrder(); // new 统一下单输入对象
        $input->setBody("test");   // 商品描述
        $input->setAttach("test"); //附加数据
        $input->setOutTradeNo(WxPayConfig::MCHID.date("YmdHis")); //商户系统内部的订单号
        $input->setTotalFee("1"); // 标价金额
        $input->setTimeStart(date("YmdHis")); // 交易起始时间
        $input->setTimeExpire(date("YmdHis", time() + 600)); // 交易结束时间
        $input->setGoodsTag("test"); // 订单优惠标记
        $input->setNotifyUrl(request()->domain() . url('wxpay/notify')); // 通知地址
        $input->setTradeType("NATSIVE"); // 交易类型
        $input->setProductId($id); // 商品ID

        $notify = new NativePay();
        $result = $notify->getPayUrl($input); // 模式二生成支付url
        $url2 = empty($result["code_url"]) ? '' : $result["code_url"];

        return '<img alt="扫码支付" src="/wxpayapi/example/qrcode.php?data=' . urlencode($url2) . '" style="width:300px;height:300px;"/>';
    }
}
