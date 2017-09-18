<?php
namespace wxpay;

use wxpay\database\WxPayBizPayUrl;

/**
 * 刷卡支付实现类
 *
 * Class NativePay
 * @package wxpay
 * @author goldeagle
 */
class NativePay
{
    /**
     * 生成扫描支付URL,模式一
     * @param \wxpay\database\WxPayBizPayUrl $productId
     * @return string
     */
    public function getPrePayUrl($productId)
    {
        $biz = new WxPayBizPayUrl();
        $biz->setProductId($productId);
        $values = WxPayApi::bizpayurl($biz);
        $url = "weixin://wxpay/bizpayurl?" . $this->toUrlParams($values);
        return $url;
    }

    /**
     * 参数数组转换为url参数
     * @param $urlObj
     * @return string
     */
    private function toUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v) {
            $buff .= $k . "=" . $v . "&";
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    /**
     * 生成直接支付url，支付url有效期为2小时,模式二
     * @param database\WxPayUnifiedOrder $input
     * @return array
     */
    public function getPayUrl($input)
    {
        $result = [];
        if ($input->getTradeType() == "NATIVE") {
            $result = WxPayApi::unifiedOrder($input);
        }
        return $result;
    }
}