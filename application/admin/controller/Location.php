<?php
namespace app\admin\controller;

use think\Controller;
use extend\Map;

/**
 * 主平台门店管理控制器
 */

class Location extends Controller
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
     * 已审核门店列表
     * @return [type] [description]
     */
    public function index()
    {
        $location = $this->model->getLocationByStatus(1); //已审核
        return $this->fetch('', ['location' => $location]);
    }

    /**
     * 待审核门店
     * @return [type] [description]
     */
    public function apply()
    {
        $location = $this->model->getLocationByStatus(); //待审核
        return $this->fetch('', ['location' => $location]);
    }
    
    /**
     * 已下架门店
     * @return [type] [description]
     */
    public function del()
    {
        $location = $this->model->getLocationByStatus(-1); //已下架
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
        $bisLocation = model('BisLocation')->where(['id' => $id])->field($field, true)->find();

        // 所属一级城市
        $city = model('City')->getCityNameByid($bisLocation->city_id);
       
        // 所属一级分类
        $category = model('Category')->getCategoryNameById($bisLocation->category_id);

        return $this->fetch('', [
            'bisLocation' => $bisLocation,
            'category' => $category,
            'city' => $city,
        ]);
    }

    /**
     * 修改门店状态值
     * @return [type] [description]
     */
    public function status()
    {
        $data = input('get.');

        // 验证
        $validate = validate('BisLocation');
        if(!$validate->scene('status')->check($data)){
            $this->error($validate->getError());
        }

        // 入库
        $result =  $this->model->where(['id' => $data['id']])->update(['status' => (int)$data['status']]);
        switch ($data['status']) {
            case -1: $msg = '下架'; break;
            case  1: $msg = '上架'; break;
            default: $msg = '状态修改';
        }
        if($result === false){
            $this->error($msg . '失败，请重试');
        }

        // 邮件通知
        $mail = new \Mail;
        $location = $this->model->where(['id' => $data['id']])->field(['name', 'bis_id'])->find();
        $email = model('Bis')->where(['id' => $location->bis_id])->value('email');
        $username = model('BisAccount')->where(['bis_id' => $location->bis_id])->value('username');
        $title = config('web.web_name') . '门店最新状态通知';
        $statusText = locationStatus((int)$data['status']);
        $content = <<<EOF
<div style="margin: 0; padding: 16px 2em; background: #e0f3f7; color: #333;">
<p>您好，{$username}！</p>
<p>关于您的门店【{$location->name}】，最新状态通知如下：</p>
<p style="color: #f00;">{$statusText}</p></div>
EOF;
        $mail->sendMail($email, $username, $title, $content);
        $this->success($msg . '成功');
    }

}