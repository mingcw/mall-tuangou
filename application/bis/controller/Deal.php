<?php
namespace app\bis\controller;
use think\Controller;

/**
 * 团购商品管理控制器
 */
class Deal extends Common
{
    protected $model;

    /**
     * 模型初始化
     * @return [type] [description]
     */
    protected function _initialize()
    {
        $this->model = model('Deal');
    }

    /**
     * 团购商品列表
     * @return [type] [description]
     */
    public function index()
    {
        // 获取登录商户ID
        $bisId = $this->getLoginBis()->bis_id;
       
        // 获取该商户所有团购商品
        $deal = $this->model->getDealByBisId($bisId);
        return $this->fetch('', ['deal' => $deal]);
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
                'location_ids' => empty($data['location_ids']) ? '' : implode(',',$data['location_ids']),
                'image' => $data['image'],
                'description' => $data['description'],
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'city_id' => empty($data['se_city_id']) ? $data['city_id'] : $data['se_city_id'],
                'total_count' => $data['total_count'],
                'coupons_start_time' => strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'x_point' => $location->x_point,
                'y_point' => $location->y_point,
                'bis_account_id' => $bisAccount->id,
                'notes' => $data['notes'],
            ];
            $result = $this->model->save($saveData);
            if($result === false){
                $this->error('申请失败，请重试');
            }
            $dealId = $this->model->getLastInsId();

            // 邮件通知
            $mail = new \Mail;
            $bisId = $this->getLoginBis()->bis_id;
            $email = model('Bis')->where(['id' => $bisId])->value('email');
            $username = model('BisAccount')->where(['bis_id' => $bisId])->value('username');
            $title = config('web.web_name') . '商品添加通知';
            $url = request()->domain() . url('bis/deal/waiting', ['id' => $dealId]);
            $content = <<<EOF
<div style="margin: 0; padding: 16px 2em; background: #e0f3f7; color: #333;">
<p>您好，{$username}</p>
<p>您新添加的商品正在等待审核, 请点击链接 <a href="{$url}" target="_blank" style="color: #f60;">查看</a> 最终审核结果</p></div>
EOF;
            $mail->sendMail($email, $username, $title, $content);

            $this->success('商品添加成功，请等待审核结果', url('deal/index'));
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

    /**
     * 等待审核视图
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function waiting() {
        $data = [
            'id' => input('id', 0, 'intval')
        ];
        if(!$data['id']) {
            return $this->error('页面不存在');
        }

        $field = ['id', 'name', 'status'];
        $deal = $this->model->where(['id' => $data['id']])->field($field)->find();
        return $this->fetch('', ['deal' => $deal]);
    }

     /**
     * 商品详情视图
     * @return [type] [description]
     */
    public function detail()
    {
        $id = input('id', 0, 'intval');
        if(!$id){
            $this->error('页面不存在');
        }

        // 商品信息
        $field = ['is_main', 'api_address', 'bis_id', 'sell_count', 'x_point', 'y_point', 'balance_price', 'sort', 'status', 'create_time', 'update_time'];
        $deal = $this->model->where(['id' => $id])->field($field, true)->find();

        // 所属城市
        $city = model('City')->getCityNameById($deal->city_id);

        // 所属一级分类
        $category = model('Category')->getCategoryNameByid($deal->category_id);

        // 所属门店
        $locations = $this->model->getLocationsByDealId($id);

        return $this->fetch('', [
            'deal' => $deal,
            'city' => $city,
            'category' => $category,
            'locations' => $locations,
        ]);
    }

    /**
     * 修改商品状态值（下架）
     * @return [type] [description]
     */
    public function status()
    {
        $data = input('get.');

        // 数据验证
        $validate = validate('Deal');
        if(!$validate->scene('status')->check($data)){
            $this->error($validate->getError());
        }

        switch ($data['status']) {
            case -1: $msg = '下架'; break; // 这次的逻辑其实只有“下架”一个
            default: $msg = '状态修改';
        }

        $result =  $this->model->where(['id' => $data['id']])->update(['status' => (int)$data['status']]);
        if($result === false){
            $this->error($msg . '失败，请重试');
        }
        else{
            $this->success($msg . '成功');
        }
    }

}
