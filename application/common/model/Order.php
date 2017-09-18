<?php

namespace app\common\model;

use think\Model;

/**
 * 用户订单模型
 */
class Order extends Common
{
	 protected $insert = ['status' => 1, 'sort' => 100];

	 /**
	  * 根据本商城系统的订单号更新表
	  * @param  [type] $outTradeNo [description]
	  * @param  [type] $wxData     [description]
	  * @return [type]             [description]
	  */
	 public function updateOrderByoutTradeNo($outTradeNo, $wxData)
	 {
	 	// 组装更新数据
	 	$data = [];
	 	if(!empty(wxData['transaction_id'])){
	 		$data['transaction_id'] = wxData['transaction_id']; // 微信回调过来的支付订单号
	 	}
	 	if(!empty(wxData['total_fee'])){
	 		$data['pay_amount'] = wxData['total_fee'] / 100; // 微信回调过来的订单金额，以“分”为单位
	 		$data['pay_status'] = 1;
	 	}
	 	if(!empty(wxData['time_end'])){
	 		$data['pay_time'] = wxData['time_end']; // 微信回调过来的支付完成时间，格式为yyyyMMddHHmmss
	 	}

	 	$where = ['out_trade_no' => $outTradeNo];
	 	return $this->where($where)->allowField(true)->save($data);
	 }
}