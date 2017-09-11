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
        return $this->fetch();
    }
    /**
     * 团购商品添加
     */
    public function add()
    {
        if(request()->isPost()){ // 处理表单
            $data = input('post.');
            var_dump($data);die;
            $validate = validate('Deal');
            if(!$validate->scene('add')->check($data)){
                $this->error('页面不存在');
            }
            $saveData = [
                'name' => $data['name'],
                'category_id' => $data['category_id'],
                'se_category_id' => empty($data['se_category_id']) ? '' : implode(',',$data['se_category_id']),
                'bis_id' => $this->getLoginUser()->bis_id,
                'location_ids' => empty($data['location_ids'])?'':implode(',',$data['location_ids']),
                'image' => $data['image'],
                'description' => $data['description'],
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'city_id' => $data['city_id'],
                'total_count' => $data['total_count'],
                'coupons_begin_time' => strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'xpoint'=>$location->xpoint,
                'ypoint'=>$location->ypoint
                'bis_account_id'=>$this->getLoginUser()->id,
                'notes' => $data['notes'],
            ];
            $result = model('Deal')->save($saveData);
            if($result === false){
                $this->error('添加失败，请重试');
            }
            else{
                $this->success('添加成功', url('deal/index'));
            }
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
