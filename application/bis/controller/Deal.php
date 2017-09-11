<?php
namespace app\bis\controller;
use think\Controller;

/**
 * 团购管理控制器
 */
class Deal extends Common
{
    /**
     * 团购商品列表
     * @return [type] [description]
     */
    public function index()
    {
        echo __FUNCTION__;die;
        return $this->fetch();
    }
    /**
     * 团购商品添加
     */
    public function add()
    {
        if(request()->isPost()){ // 处理表单
            $data = input('post.');

            // 验证
            $validate = validate('Deal');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }

            // 入库
            $bisAccount = $this->getLoginBis();
            $location = model('BisLocation')->where(['id' => $data['location_ids'][0]])->field(['x_point', 'y_point'])->find();
            $saveData = [
                'name' => $data['name'],
                'category_id' => $data['category_id'],
                'se_category_id' => empty($data['se_category_id']) ? '' : implode(',',$data['se_category_id']),
                'bis_id' => $bisAccount->bis_id,
                'location_ids' => empty($data['location_ids'])?'':implode(',',$data['location_ids']),
                'image' => $data['image'],
                'description' => $data['description'],
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'city_id' => $data['city_id'],
                'total_count' => $data['total_count'],
                'coupons_start_time' => strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'x_point' => $location->x_point,
                'y_point' => $location->y_point,
                'bis_account_id' => $bisAccount->id,
                'notes' => $data['notes'],
            ];
            $result = model('Deal')->save($saveData);
            if($result === false){
                $this->error('添加失败，请重试');
            }

            $this->success('添加成功', url('deal/index'));
        }
        else{
            // 一级城市
            $citys = model('City')->getNormalCitysByParentId();
            // 一级分类
            $categorys = model('Category')->getNormalCategoryByParentId();
            // 商户门店
            $bisId = $this->getLoginBis()->bis_id;
            $bisLocation = model('BisLocation')->getNormalLocatinByBisId($bisId);
            return $this->fetch('', ['categorys' => $categorys, 'citys' => $citys, 'bisLocation' => $bisLocation]);
        }
    }
}
