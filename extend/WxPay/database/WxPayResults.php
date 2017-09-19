<?php
namespace wxpay\database;

use wxpay\WxPayException;

/**
 * 接口调用结果类
 *
 * Class WxPayResults
 * @package wxpay\database
 * @author goldeagle
 */
class WxPayResults extends WxPayDataBase
{
    /**
     *
     * 检测签名
     */
    public function checkSign()
    {
        //fix异常
        if (!$this->isSignSet()) {
            throw new WxPayException("签名错误！");
        }

        $sign = $this->makeSign();
        if ($this->getSign() == $sign) {
            return true;
        }
        throw new WxPayException("签名错误！");
    }

    /**
     *
     * 使用数组初始化
     * @param array $array
     */
    public function fromArray($array)
    {
        $this->values = $array;
    }

    /**
     * 使用数组初始化对象
     * @param $array
     * @param bool $nocheckSign 是否检测签名
     * @return WxPayResults
     */
    public static function InitFromArray($array, $nocheckSign = false)
    {
        $obj = new self();
        $obj->fromArray($array);
        if ($nocheckSign == false) {
            $obj->checkSign();
        }
        return $obj;
    }

    /**
     *
     * 设置参数
     * @param string $key
     * @param string $value
     */
    public function setData($key, $value)
    {
        $this->values[$key] = $value;
    }

    /**
     * 将xml转为array
     * @param string $xml
     * @return array
     */
    public static function Init($xml)
    {
        $obj = new self();
        $obj->fromXml($xml);
        //fix bug 2015-06-29
        if ($obj->values['return_code'] != 'SUCCESS') {
            return $obj->getValues();
        }
        $obj->checkSign();
        return $obj->getValues();
    }
}