<?php
namespace app\index\controller;

use think\Controller;
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
     * 用户支付后，商户后台得到通知的回调方法
     * @return [type] [description]
     */
    public function notify()
    {
        $resultXml = file_get_contents('php://input');
        file_put_contents('/tmp/WxNotify.xml', $resultXml, FILE_APPEND);
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
        $input->setNotifyUrl(url('wxpay/notify')); // 通知地址
        $input->setTradeType("NATSIVE"); // 交易类型
        $input->setProductId($id); // 商品ID

        $notify = new NativePay();
        $result = $notify->getPayUrl($input); // 模式二生成支付url
        $url2 = empty($result["code_url"]) ? '' : $result["code_url"];

        return '<img alt="扫码支付" src="/wxpayapi/example/qrcode.php?data=' . urlencode($url2) . '" style="width:300px;height:300px;"/>';
    }
}
