<?php
namespace app\index\controller;

use think\Controller;

/**
 * 列表页控制器
 */
class Lists extends Common
{
	/**
	 * 列表页视图
	 * @return [type] [description]
	 */
	public function index()
	{
		// 顶级分类
		$topCates = model('Category')->getNormalCategoryByParentId();
		$topIds = [];
		foreach ($topCates as $v) {
			$topIds[] = $v->id;
		}

		$id = input('get.id', 0, 'intval');


		// 获取父分类ID $pid，并获取顶或二级的分类id $cateId组装到 where 条件
		$where = [];
		$field = ['id', 'name', 'parent_id', 'status'];
		$order = ['sort' => 'asc', 'id' => 'desc'];
		if(in_array($id, $topIds)){// 顶级分类
			$pid = $id;
			$where['category_id'] = $id;
		}
		else if($id){ // 子级分类
			$sub = model('Category')->field($field)->order($order)->find($id);
			if(!$sub || $sub->status != 1){
				$this->error('页面不存在');
			}
			$pid = $sub->parent_id;
			$where['se_category_id'] = $id;
		}
		else{ // id = 0
			$pid = 0;
		}
		$where['city_id'] = $this->city->id; // 当前城市

		// 获取子级分类
		$subCates = [];
		if($pid){
			$subCates = model('Category')->getNormalCategoryByParentId($pid);
		}

		// 获取不同的排序类型
		$sort_sale  = input('sort_sale', '');   // 按销量倒序
		$sort_price = input('sort_price', '');  // 按价格倒序
		$sort_time  = input('sort_time', '');   // 按时间倒序
		$sort      = [];
		if(!empty($sort_sale)){
			$sortFlag = 'sort_sale';
			$sort['sort_sale'] = $sort_sale;
		}
		else if(!empty($sort_price)){
			$sortFlag = 'sort_price';
			$sort['sort_price'] = $sort_price;
		}
		else if(!empty($sort_time)){
			$sortFlag = 'sort_time';
			$sort['sort_time'] = $sort_time;
		}
		else{
			$sortFlag = '';
		}

		// 根据以上条件查询商品列表
		$deals = model('Deal')->getDealByConditions($where, $sort);

		return $this->fetch('', [
			'topCates' => $topCates,
			'subCates' => $subCates,
			'id' => $id,
			'pid' => $pid,
			'sortFlag' => $sortFlag,
			'deals' => $deals,
		]);
	}
}