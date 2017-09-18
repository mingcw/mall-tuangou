<?php
namespace wxpay;
/**
 * 微信支付API异常类
 *
 * Class WxPayException
 * @package wxpay
 * @author goldeagle
 */
class WxPayException extends \Exception
{
    public function errorMessage()
    {
        return $this->getMessage();
    }
}