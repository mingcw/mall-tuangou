<?php

namespace app\api\controller;

use think\Controller;
use think\Request;

/**
 * 订单接口
 */
class Order extends Controller
{
    protected $model;

    /**
     * 模型初始化
     * @return [type] [description]
     */
    protected function _initialize()
    {
        $this->model = model('Order');
    }

    /**
     * 获取支付结果
     * @return [type] [description]
     */
    public function payStatus()
    {
        if(!session('?user', '', 'index')){
            $this->result($_SERVER['HTTP_REFERER'], 2, '未登录'); // 未登录，code 为 2
        }

        $id = input('post.id', 0, 'intval');
        if(!$id){
            return $this->error('页面不存在');
        }

        // 订单信息
        $field = ['id', 'pay_status'];
        $order = $this->model->field($field)->find($id);

        ob_end_clean();
         $this->result($_SERVER['HTTP_REFERER'], 0, 'ok');die; // 成功，code 为 0
        if($order->pay_status == 1){
            $this->result($_SERVER['HTTP_REFERER'], 0, 'ok'); // 成功，code 为 0
        }
        else{
            $this->result($_SERVER['HTTP_REFERER'], 1, 'failed'); // 失败，code 为 1
        }
    }
}