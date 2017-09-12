<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

/**
 * 主平台商户管理控制器
 */
class Bis extends Controller
{
    protected $model;

    /**
     * 模型初始化
     * @return [type] [description]
     */
    protected function _initialize()
    {
        $this->model = model('Bis');
    }

    /**
     * 已入驻商户列表视图
     * @return [type] [description]
     */
    public function index()
    {
        $bis = $this->model->getBisByStatus(1); //已入驻列表（通过审核）
        return $this->fetch('', ['bis' => $bis]);
    }

    /**
     * 商户入驻申请列表视图
     * @return [type] [description]
     */
    public function apply()
    {
        $bis = $this->model->getBisByStatus(); //入驻申请列表
        return $this->fetch('', ['bis' => $bis]);
    }

    /**
     * 商户详情视图
     * @return [type] [description]
     */
    public function detail()
    {
        $id = input('id', 0, 'intval');
        if(!$id){
            $this->error('页面不存在');
        }

        // 商户信息
        $field = ['money', 'sort', 'status', 'create_time', 'update_time'];
        $bis = model('Bis')->where(['id' => $id])->field($field, true)->find();
        if(!$bis['id']){
            $this->error('页面不存在');
        }

        // 总店信息
        $field = ['is_main', 'api_address', 'sort', 'status', 'create_time', 'update_time'];
        $bisLocation = model('BisLocation')->where(['bis_id' => $id, 'is_main' => 1])->field($field, true)->find();

        // 商户所属一级城市
        $city = model('City')->getCityNameById($bisLocation->city_id);
        
        // 总店所属一级分类
        $category = model('Category')->getCategoryNameById($bisLocation->category_id);
        
        // 账号信息
        $field = ['password', 'code', 'last_login_ip', 'last_login_time', 'is_main', 'sort', 'status', 'create_time', 'update_time'];
        $bisAccount = model('BisAccount')->where(['bis_id' => $id, 'is_main' => 1])->field($field, true)->find();
       

        return $this->fetch('', [
            'category' => $category,
            'city' => $city,
            'bis' => $bis,
            'bisLocation' => $bisLocation,
            'bisAccount' => $bisAccount
        ]);
    }

    /**
     * 修改商户状态值
     * @return [type] [description]
     */
    public function status()
    {
        $data = input('get.');
        
        // 数据验证（因为商户、门店、账号表需要验证的数据和类型都一样，所以只验证一张表数据即可）
        $validate = validate('Bis');
        if(!$validate->scene('status')->check($data)){
            $this->error($validate->getError());
        }

        switch ($data['status']) {
            case -1: $msg = '删除'; break;
            default: $msg = '状态修改';
        }

        $result1 = $this->model->where(['id' => $data['id']])->update(['status' => (int)$data['status']]);
        $result2 = model('BisLocation')->where(['bis_id' => $data['id'], 'is_main' => 1])->update(['status' => (int)$data['status']]);
        $result3 = model('BisAccount')->where(['bis_id' => $data['id'], 'is_main' => 1])->update(['status' => (int)$data['status']]);

        if($result1 === false || $result2 === false || $result3 === false){
            $this->error($msg . '失败，请重试');
        }
        else{
            // 邮件通知
            $mail = new \Mail;
            
            $email = model('Bis')->where(['id' => $data['id']])->value('email');
            $username = model('BisAccount')->where(['bis_id' => $data['id']])->value('username');
            $title = config('web.web_name') . '入驻审核通知';
            $content = $username . '，' . bisStatus((int)$data['status']);

            $mail->sendMail($email, $username, $title, $content);
            $this->success($msg . '成功');
        }
    }

}
