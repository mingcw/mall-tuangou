<?php
namespace app\index\controller;

use think\Controller;

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
        $id = input('get.id', 0, 'intval');
        
        // 调用微信API响应一个二维码，用户扫码支付
        
        return '订单支付处理完成';
    }
}
