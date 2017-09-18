<?php
namespace wxpay\database;

/**
 * 短链转换输入对象
 * Class WxPayShortUrl
 * @package wxpay\database
 * @author goldeagle
 */
class WxPayShortUrl extends WxPayDataBase
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
     * 设置需要转换的URL，签名用原串，传输需URL encode
     * @param string $value
     **/
    public function setLongUrl($value)
    {
        $this->values['long_url'] = $value;
    }

    /**
     * 获取需要转换的URL，签名用原串，传输需URL encode的值
     * @return string 值
     **/
    public function getLongUrl()
    {
        return $this->values['long_url'];
    }

    /**
     * 判断需要转换的URL，签名用原串，传输需URL encode是否存在
     * @return true 或 false
     **/
    public function isLongUrlSet()
    {
        return array_key_exists('long_url', $this->values);
    }


    /**
     * 设置随机字符串，不长于32位。推荐随机数生成算法
     * @param string $value
     **/
    public function setNonceStr($value)
    {
        $this->values['nonce_str'] = $value;
    }

    /**
     * 获取随机字符串，不长于32位。推荐随机数生成算法的值
     * @return string 值
     **/
    public function getNonceStr()
    {
        return $this->values['nonce_str'];
    }

    /**
     * 判断随机字符串，不长于32位。推荐随机数生成算法是否存在
     * @return true 或 false
     **/
    public function isNonceStrSet()
    {
        return array_key_exists('nonce_str', $this->values);
    }
}