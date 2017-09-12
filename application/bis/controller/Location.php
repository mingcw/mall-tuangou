<?php
namespace app\bis\controller;
use think\Controller;

/**
 * 商户门店控制器
 */
class Location extends Common
{
    protected $model;

    /**
     * 模型初始化
     * @return [type] [description]
     */
    protected function _initialize()
    {
        $this->model = model('BisLocation');
    }

    /**
     * 待审核门店列表
     * @return [type] [description]
     */
    public function index()
    {
        // 获取登录商户ID
        $bisId = $this->getLoginBis()->bis_id;
        // 获取该商户所有门店
        $location = $this->model->getLocationByBisId($bisId);
        return $this->fetch('', ['location' => $location]);
    }

    /**
     * 新增门店
     */
    public function add()
    {
        if(request()->isPost()){
            $data = input('post.');

            // 获取经纬度
            $lngLat = \Map::getLngLat($data['address']);
            if(empty($lngLat) || $lngLat['status'] != 0 || $lngLat['result']['precise'] != 1){
                return $this->result('', 1, '无法获取数据，或者匹配的地址不精确');
            }

            // 验证门店信息
            $validate = validate('BisLocation');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }

            // 门店信息入库
            $bisId = $this->getLoginBis()->bis_id;
            $locationData = [
                'name' => $data['name'],
                'logo' => $data['logo'],
                'address' => $data['address'],
                'tel' => $data['tel'],
                'contact_user' => $data['contact'],
                'x_point' => $lngLat['result']['location']['lng'],
                'y_point' => $lngLat['result']['location']['lat'],
                'bis_id' => $bisId,
                'open_time' => $data['open_time'],
                'introduce' => empty($data['content'])?'':$data['content'],
                'is_main' => 0, // 分店
                'api_address' => $data['address'],
                'city_id' => $data['city_id'],
                'city_path'=> empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'] . ',' . $data['se_city_id'],
                'category_id' => $data['category_id'],
                'category_path' => empty($data['se_category_id']) ? $data['category_id'] : $data['category_id'] . ',' . implode('|',$data['se_category_id']),
            ];
            $result = $this->model->save($locationData);
            if($result === false){
                $this->error('分店申请失败，请重试');
            }
            $locationId = $this->model->getLastInsId();

            // 邮件通知
            $mail = new \Mail;
            $email = model('Bis')->where(['id' => $bisId])->value('email');
            $username = model('BisAccount')->where(['bis_id' => $bisId])->value('username');
            $title = config('web.web_name') . '分店申请通知';
            $url = request()->domain() . url('bis/location/waiting', ['id' => $locationId, 'is_main' => 0]);
            $content = <<<EOF
<div style="margin: 0; padding: 16px 2em; background: #e0f3f7; color: #333;">
<p>您好，{$data['contact']}</p>
<p>您的分店申请正在等待审核, 请点击链接 <a href="{$url}" target="_blank" style="color: #f60;">查看</a> 最终审核结果</p></div>
EOF;
            $mail->sendMail($email, $username, $title, $content);

            $this->success('分店添加成功，请等待审核结果', url('location/index'));
        }
        else{
            // 一级城市
            $citys = model('City')->getNormalCitysByParentId();
            // 一级分类
            $categorys = model('Category')->getNormalCategoryByParentId();

            return $this->fetch('', [
                'citys' => $citys,
                'categorys' => $categorys
            ]);
        }
    }

    /**
     * 等待审核视图
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function waiting() {
        $data = [
            'id' => input('id', 0, 'intval'),
            'status' => input('status', 0, 'intval')
        ];
        if(!$data['id']) {
            return $this->error('页面不存在');
        }

        $field = ['id', 'name', 'status'];
        $location = $this->model->where(['id' => $data['id']])->field($field)->find();
        return $this->fetch('', ['location' => $location]);
    }

     /**
     * 门店详情视图
     * @return [type] [description]
     */
    public function detail()
    {
        $id = input('id', 0, 'intval');
        if(!$id){
            $this->error('页面不存在');
        }
   
        // 门店信息
        $field = ['is_main', 'api_address', 'bis_id', 'x_point', 'y_point', 'bank_account', 'sort', 'status', 'create_time', 'update_time'];
        $bisLocation = $this->model->where(['id' => $id])->field($field, true)->find();

        // 所属一级城市
        $city = model('City')->getCityNameById($bisLocation->city_id);
 
        // 所属一级分类
        $category = model('Category')->getCategoryNameById($bisLocation->category_id);

        return $this->fetch('', [
            'bisLocation' => $bisLocation,
            'city' => $city,
            'category' => $category,
        ]);
    }

    /**
     * 修改门店状态值（下架）
     * @return [type] [description]
     */
    public function status()
    {
        $data = input('get.');

        // 数据验证
        $validate = validate('BisLocation');
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
