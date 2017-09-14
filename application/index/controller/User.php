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
        return $this->fetch();
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

             // 邮件通知
            $mail = new \Mail;
            $webName = config('web.web_name');
            $title = $webName . '会员注册通知';
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
