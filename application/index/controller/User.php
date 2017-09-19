<?php
namespace app\index\controller;

use think\Controller;

/**
 * 前台用户控制器
 */
class User extends Controller
{
    /**
     * 登录视图
     * @return [type] [description]
     */
    public function login()
    {
        if(request()->isPost()) {
            $data = input('post.');

             // 验证
            if(!trim($data['verify'])){
                $this->error('验证码不能为空');
            }
            if(!captcha_check($data['verify'])){
                $this->error('验证码有误，请重新输入');
            }
            $validate = validate('User');
            if(!$validate->scene('login')->check($data)){
                $this->error($validate->getError());
            }
            $model = model('User');
            $where = ['username' => $data['username']];
            $field = ['id', 'username', 'password', 'email', 'code', 'status'];
            $user = $model->where($where)->field($field)->find();
            if(!$user || $user->status != 1){
                $this->error('该用户不存在');
            }
            else if(encrypt($data['password'], $user->code) != $user->password){
                $this->error('密码不正确');
            }

            // 写session
            session('user', $user, 'index');

            // 更新数据库
            $updateData = [
                'last_login_ip' => request()->ip(),
                'last_login_time' => time(),
            ];
            $where = ['id' => $user->id];
            $model->update($updateData, $where);
            
            return $this->success('登录成功', url('/'));
        }
        else{
            session(null, 'index');
            return $this->fetch();
        }
    }

    /**
     * 退出登录
     * @return [type] [description]
     */
    public function logout()
    {
        session(null, 'index');
        $this->redirect('user/login');
    }

    /**
     * 注册视图
     * @return [type] [description]
     */
    public function register()
    {
        if(request()->isPost()){
            $data = input('post.');

            // 验证
            if(!trim($data['verify'])){
                $this->error('验证码不能为空');
            }
            if(!captcha_check($data['verify'])){
                $this->error('验证码有误，请重新输入');
            }
            $validate = validate('User');
            if(!$validate->scene('register')->check($data)){
                $this->error($validate->getError());
            }
            $model = model('User');
            $where = ['username' => $data['username']];
            $whereOr = ['email' => $data['email']];
            $id = $model->where($where)->whereOr($whereOr)->value('id');
            if($id){
                $this->success('用户名或邮箱已存在，请重新输入');
            }

            // 入库
            $data['code'] = getKey();
            $data['password'] = encrypt($data['password'], $data['code']);
            $result = $model->allowField(true)->save($data);
            if($result === false){
                $this->error('注册失败，请重试');
            }

             // 邮件通知（建议走消息队列，减轻服务器压力）
            $mail = new \Mail;
            $webName = config('web.web_name');
            $title = '会员注册通知';
            $date = date('Y-m-d H:i:s', time());
            $content = <<<EOF
<div style="margin: 0; padding: 16px 2em; background: #e0f3f7; color: #333;">
<p>亲爱的用户 {$data['username']}，感谢您的注册！</p>
<p>您已成为{$webName}的注册会员，在此诚挚欢迎您的到来！</p>
<p style="color: #f00;">下面是您的注册信息：</p>
<blockquote>
<p>姓名：{$data['username']}</p>
<p>邮箱：{$data['email']}</p>
<p>注册日期：{$date}</p>
<p>祝您团购愉快！</p></blockquote></div>
EOF;
        $mail->sendMail($data['email'], $data['username'], $title, $content);

            $this->success('注册成功', url('user/login'));
        }
        else{
             return $this->fetch();
        }
    }
}
