<?php
namespace wxpay\database;

/**
 * 扫码支付模式一生成二维码参数
 * @author goldeagle
 */
class WxPayBizPayUrl extends WxPayDataBase
{
    /**
     * 设置微信分配的公众账号ID
     * @param string $value
     **/
    public function setAppid($value)
    {
        $this->values['appid'] = $value;
    }

    /**
     * 获取微信分配的公众账号ID的值
     * @return string 值
     **/
    public function getAppid()
    {
        return $this->values['appid'];
    }

    /**
     * 判断微信分配的公众账号ID是否存在
     * @return true 或 false
     **/
    public function isAppidSet()
    {
        return array_key_exists('appid', $this->values);
    }

    /**
     * 设置微信支付分配的商户号
     * @param string $value
     **/
    public function setMchId($value)
    {
        $this->values['mch_id'] = $value;
    }

    /**
     * 获取微信支付分配的商户号的值
     * @return string 值
     **/
    public function getMchId()
    {
        return $this->values['mch_id'];
    }

    /**
     * 判断微信支付分配的商户号是否存在
     * @return true 或 false
     **/
    public function isMchIdSet()
    {
        return array_key_exists('mch_id', $this->values);
    }

    /**
     * 设置支付时间戳
     * @param string $value
     **/
    public function setTimeStamp($value)
    {
        $this->values['time_stamp'] = $value;
    }

    /**
     * 获取支付时间戳的值
     * @return string 值
     **/
    public function getTimeStamp()
    {
        return $this->values['time_stamp'];
    }

    /**
     * 判断支付时间戳是否存在
     * @return true 或 false
     **/
    public function isTimeStampSet()
    {
        return array_key_exists('time_stamp', $this->values);
    }

    /**
     * 设置随机字符串
     * @param string $value
     **/
    public function setNonceStr($value)
    {
        $this->values['nonce_str'] = $value;
    }

    /**
     * 获取随机字符串的值
     * @return string 值
     **/
    public function getNonceStr()
    {
        return $this->values['nonce_str'];
    }

    /**
     * 判断随机字符串是否存在
     * @return true 或 false
     **/
    public function isNonceStrSet()
    {
        return array_key_exists('nonce_str', $this->values);
    }

    /**
     * 设置商品ID
     * @param string $value
     **/
    public function setProductId($value)
    {
        $this->values['product_id'] = $value;
    }

    /**
     * 获取商品ID的值
     * @return string 值
     **/
    public function getProductId()
    {
        return $this->values['product_id'];
    }

    /**
     * 判断商品ID是否存在
     * @return true 或 false
     **/
    public function isProductIdSet()
    {
        return array_key_exists('product_id', $this->values);
    }
}