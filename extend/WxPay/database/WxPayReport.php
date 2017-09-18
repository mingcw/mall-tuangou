<?php
namespace wxpay\database;

/**
 * 测速上报输入对象
 *
 * Class WxPayReport
 * @package wxpay\database
 * @author goldeagle
 */
class WxPayReport extends WxPayDataBase
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
     * 设置微信支付分配的终端设备号，商户自定义
     * @param string $value
     **/
    public function setDeviceInfo($value)
    {
        $this->values['device_info'] = $value;
    }

    /**
     * 获取微信支付分配的终端设备号，商户自定义的值
     * @return string 值
     **/
    public function getDeviceInfo()
    {
        return $this->values['device_info'];
    }

    /**
     * 判断微信支付分配的终端设备号，商户自定义是否存在
     * @return true 或 false
     **/
    public function isDeviceInfoSet()
    {
        return array_key_exists('device_info', $this->values);
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


    /**
     * 设置上报对应的接口的完整URL，类似：https://api.mch.weixin.qq.com/pay/unifiedorder对于被扫支付，为更好的和商户共同分析一次业务行为的整体耗时情况，对于两种接入模式，请都在门店侧对一次被扫行为进行一次单独的整体上报，上报URL指定为：https://api.mch.weixin.qq.com/pay/micropay/total关于两种接入模式具体可参考本文档章节：被扫支付商户接入模式其它接口调用仍然按照调用一次，上报一次来进行。
     * @param string $value
     **/
    public function setInterfaceUrl($value)
    {
        $this->values['interface_url'] = $value;
    }

    /**
     * 获取上报对应的接口的完整URL，类似：https://api.mch.weixin.qq.com/pay/unifiedorder对于被扫支付，为更好的和商户共同分析一次业务行为的整体耗时情况，对于两种接入模式，请都在门店侧对一次被扫行为进行一次单独的整体上报，上报URL指定为：https://api.mch.weixin.qq.com/pay/micropay/total关于两种接入模式具体可参考本文档章节：被扫支付商户接入模式其它接口调用仍然按照调用一次，上报一次来进行。的值
     * @return string 值
     **/
    public function getInterfaceUrl()
    {
        return $this->values['interface_url'];
    }

    /**
     * 判断上报对应的接口的完整URL，类似：https://api.mch.weixin.qq.com/pay/unifiedorder对于被扫支付，为更好的和商户共同分析一次业务行为的整体耗时情况，对于两种接入模式，请都在门店侧对一次被扫行为进行一次单独的整体上报，上报URL指定为：https://api.mch.weixin.qq.com/pay/micropay/total关于两种接入模式具体可参考本文档章节：被扫支付商户接入模式其它接口调用仍然按照调用一次，上报一次来进行。是否存在
     * @return true 或 false
     **/
    public function isInterfaceUrlSet()
    {
        return array_key_exists('interface_url', $this->values);
    }


    /**
     * 设置接口耗时情况，单位为毫秒
     * @param string $value
     **/
    public function setExecuteTime($value)
    {
        $this->values['execute_time_'] = $value;
    }

    /**
     * 获取接口耗时情况，单位为毫秒的值
     * @return string 值
     **/
    public function getExecuteTime()
    {
        return $this->values['execute_time_'];
    }

    /**
     * 判断接口耗时情况，单位为毫秒是否存在
     * @return true 或 false
     **/
    public function isExecuteTimeSet()
    {
        return array_key_exists('execute_time_', $this->values);
    }

    /**
     * 设置SUCCESS/FAIL此字段是通信标识，非交易标识，交易是否成功需要查看trade_state来判断
     * @param string $value
     **/
    public function setReturnCode($value)
    {
        $this->values['return_code'] = $value;
    }

    /**
     * 获取SUCCESS/FAIL此字段是通信标识，非交易标识，交易是否成功需要查看trade_state来判断的值
     * @return string 值
     **/
    public function getReturnCode()
    {
        return $this->values['return_code'];
    }

    /**
     * 判断SUCCESS/FAIL此字段是通信标识，非交易标识，交易是否成功需要查看trade_state来判断是否存在
     * @return true 或 false
     **/
    public function isReturnCodeSet()
    {
        return array_key_exists('return_code', $this->values);
    }


    /**
     * 设置返回信息，如非空，为错误原因签名失败参数格式校验错误
     * @param string $value
     **/
    public function setReturnMsg($value)
    {
        $this->values['return_msg'] = $value;
    }

    /**
     * 获取返回信息，如非空，为错误原因签名失败参数格式校验错误的值
     * @return string 值
     **/
    public function getReturnMsg()
    {
        return $this->values['return_msg'];
    }

    /**
     * 判断返回信息，如非空，为错误原因签名失败参数格式校验错误是否存在
     * @return true 或 false
     **/
    public function isReturnMsgSet()
    {
        return array_key_exists('return_msg', $this->values);
    }


    /**
     * 设置SUCCESS/FAIL
     * @param string $value
     **/
    public function setResultCode($value)
    {
        $this->values['result_code'] = $value;
    }

    /**
     * 获取SUCCESS/FAIL的值
     * @return string 值
     **/
    public function getResultCode()
    {
        return $this->values['result_code'];
    }

    /**
     * 判断SUCCESS/FAIL是否存在
     * @return true 或 false
     **/
    public function isResultCodeSet()
    {
        return array_key_exists('result_code', $this->values);
    }

    /**
     * 设置ORDERNOTEXIST—订单不存在SYSTEMERROR—系统错误
     * @param string $value
     **/
    public function setErrCode($value)
    {
        $this->values['err_code'] = $value;
    }

    /**
     * 获取ORDERNOTEXIST—订单不存在SYSTEMERROR—系统错误的值
     * @return string 值
     **/
    public function getErrCode()
    {
        return $this->values['err_code'];
    }

    /**
     * 判断ORDERNOTEXIST—订单不存在SYSTEMERROR—系统错误是否存在
     * @return true 或 false
     **/
    public function isErrCodeSet()
    {
        return array_key_exists('err_code', $this->values);
    }

    /**
     * 设置结果信息描述
     * @param string $value
     **/
    public function setErrCodeDes($value)
    {
        $this->values['err_code_des'] = $value;
    }

    /**
     * 获取结果信息描述的值
     * @return string 值
     **/
    public function getErrCodeDes()
    {
        return $this->values['err_code_des'];
    }

    /**
     * 判断结果信息描述是否存在
     * @return true 或 false
     **/
    public function isErrCodeDesSet()
    {
        return array_key_exists('err_code_des', $this->values);
    }

    /**
     * 设置商户系统内部的订单号,商户可以在上报时提供相关商户订单号方便微信支付更好的提高服务质量。
     * @param string $value
     **/
    public function setOutTradeNo($value)
    {
        $this->values['out_trade_no'] = $value;
    }

    /**
     * 获取商户系统内部的订单号,商户可以在上报时提供相关商户订单号方便微信支付更好的提高服务质量。 的值
     * @return string 值
     **/
    public function getOutTradeNo()
    {
        return $this->values['out_trade_no'];
    }

    /**
     * 判断商户系统内部的订单号,商户可以在上报时提供相关商户订单号方便微信支付更好的提高服务质量。 是否存在
     * @return true 或 false
     **/
    public function isOutTradeNoSet()
    {
        return array_key_exists('out_trade_no', $this->values);
    }


    /**
     * 设置发起接口调用时的机器IP
     * @param string $value
     **/
    public function setUserIp($value)
    {
        $this->values['user_ip'] = $value;
    }

    /**
     * 获取发起接口调用时的机器IP 的值
     * @return string 值
     **/
    public function getUserIp()
    {
        return $this->values['user_ip'];
    }

    /**
     * 判断发起接口调用时的机器IP 是否存在
     * @return true 或 false
     **/
    public function isUserIpSet()
    {
        return array_key_exists('user_ip', $this->values);
    }

    /**
     * 设置系统时间，格式为yyyyMMddHHmmss，如2009年12月27日9点10分10秒表示为20091227091010。其他详见时间规则
     * @param string $value
     **/
    public function setTime($value)
    {
        $this->values['time'] = $value;
    }

    /**
     * 获取系统时间，格式为yyyyMMddHHmmss，如2009年12月27日9点10分10秒表示为20091227091010。其他详见时间规则的值
     * @return string 值
     **/
    public function getTime()
    {
        return $this->values['time'];
    }

    /**
     * 判断系统时间，格式为yyyyMMddHHmmss，如2009年12月27日9点10分10秒表示为20091227091010。其他详见时间规则是否存在
     * @return true 或 false
     **/
    public function isTimeSet()
    {
        return array_key_exists('time', $this->values);
    }
}