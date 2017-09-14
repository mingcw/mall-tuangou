<?php
namespace app\bis\controller;
use think\Controller;

/**
 * 商户登录控制器
 */
class Login extends Controller
{
    /**
     * 登录视图和表单处理
     * @return [type] [description]
     */
    public function index()
    {
        if(request()->isPost()){ // 处理表单
            $data = input('post.');
            
            // 验证
            $validate = validate('BisAccount');
            if(!$validate->scene('logiin')->check($data)){
                $this->error($validate->getError());
            }
            
            $model = model('BisAccount');
            $where = ['username' => $data['username']];
            $field = ['sort', 'create_time', 'update_time'];
            $bis = $model->where($where)->field($field, true)->find();
            if(!$bis || $bis->status != 1){
                $this->error('用户名不存在或未通过审核');
            }
            else if(encrypt($data['password'], $bis->code) != $bis->password){
                $this->error('密码不正确');
            }

            // 写session
            session('bisAccount', $bis, 'bis');

            // 更新数据库
            $updateData = [
                'last_login_ip' => request()->ip(),
                'last_login_time' => time(),
            ];
            $where = ['username' => $data['username']];
            $model->update($updateData, $where);
            
            return $this->success('登录成功', url('index/index'));
        }
        else{
            session(null, 'bis');
            return $this->fetch();
        }
    }

    /**
     * 退出登录
     * @return [type] [description]
     */
    public function logout(){
        session(null, 'bis');
        $this->redirect('login/index');
    }
}