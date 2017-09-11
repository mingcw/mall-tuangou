<?php
namespace app\bis\controller;
use think\Controller;

/**
 * 商户注册控制器
 */
class Register extends Controller
{
    /**
     * 注册视图
     * @return [type] [description]
     */
    public function index()
    {
        // 一级城市
        $citys = model('City')->getNormalCitysByParentId();
        // 一级分类
        $category = model('Category')->getNormalCategoryByParentId();

        return $this->fetch('', ['category' => $category, 'citys' => $citys]);
    }

    /**
     * 注册表单处理
     */
    public function add()
    {
        if(!request()->isPost()){
            $this->error('页面不存在');
        }

        $data = input('post.');

        // 剔除重复用户
        if(model('BisAccount')->where(['username' => $data['username']])->value('id')){
            $this->error($data['username'] . ' 已存在');
        }

        // 获取经纬度
        $lngLat = \Map::getLngLat($data['address']);
        if(empty($lngLat) || $lngLat['status'] != 0 || $lngLat['result']['precise'] != 1){
            return $this->result('', 1, '无法获取数据，或者匹配的地址不精确');
        }

        // 验证商户信息
        $validate = validate('Bis');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }

        // 商户信息入库
        $bisData = [
            'name' => $data['name'],
            'city_id' => $data['city_id'],
            'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'] . ',' . $data['se_city_id'],
            'logo' => $data['logo'],
            'licence_logo' => $data['licence_logo'],
            'description' => empty($data['description']) ? '' :$data['description'],
            'bank_account' => $data['bank_info'],
            'bank_name' => $data['bank_name'],
            'bank_user' => $data['bank_user'],
            'faren' => $data['faren'],
            'faren_tel' => $data['faren_tel'],
            'email' => $data['email']
        ];
        $bisModel = model('Bis');
        // 开启事务
        $bisModel->startTrans();
        $result = $bisModel->save($bisData);
        if($result === false){
            $bisModel->rollBack();           // 商户信息回滚
            $this->error('添加商户信息失败，请重试');
        }
        $bisId = $bisModel->where(['name' => $data['name']])->value('id');

        // 验证门店信息
        $validate = validate('BisLocation');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }

        // 门店信息入库
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
            'is_main' => 1, // 默认总店
            'api_address' => $data['address'],
            'city_id' => $data['city_id'],
            'city_path'=> empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'] . ',' . $data['se_city_id'],
            'category_id' => $data['category_id'],
            'category_path' => empty($data['se_category_id']) ? $data['category_id'] : $data['category_id'] . ',' . implode('|',$data['se_category_id']),
            'bank_account' => $data['bank_info'],
        ];
        $bisLocationModel = model('BisLocation');
        // 开启事务
        $bisLocationModel->startTrans();
        $result = $bisLocationModel->save($locationData);
        if($result === false){
            $bisLocationModel->rollBack();  // 门店信息回滚
            $bisModel->rollBack();          // 商户信息回滚
            $this->error('添加总店信息失败，请重试');
        }

        // 验证商户账号
        $validate = validate('BisAccount');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }

        // 商户账号入库
        $data['code'] = getKey();
        $accountData = [
            'username' => $data['username'],
            'password' => encrypt($data['password'], $data['code']),
            'code' => $data['code'],
            'bis_id' => $bisId,
            'last_login_ip' => request()->ip(),
            'last_login_time' => time(),
            'is_main' => 1,               // 默认总管理员
        ];
        $bisAccountModel = model('BisAccount');
        $bisAccountModel->startTrans();   // 开启事务
        $result = $bisAccountModel->save($accountData);
        if($result === false){
            $bisAccountModel->rollBack();  // 商户账号回滚
            $bisLocationModel->rollBack(); // 门店信息回滚
            $bisModel->rollBack();         // 商户信息回滚
            $this->error('添加商户账号失败，请重试');
        }

        // 提交事务
        $bisAccountModel->commit();
        $bisLocationModel->commit();
        $bisModel->commit();

        // 邮件通知
        $mail = new \Mail;
        $title = config('web.web_name') . '入驻申请通知';
        $url = request()->domain() . url('bis/register/waiting', ['id' => $bisId]);
        $content = <<<EOF
<div style="margin: 0; padding: 16px 2em; background: #e0f3f7; color: #333;">
<p>您好，{$data['username']}，感谢您的注册</p>
<p>您的入驻申请正在等待审核, 请点击链接 <a href="{$url}" target="_blank" style="color: #f60;">查看</a> 最终审核结果</p></div>
EOF;
        $mail->sendMail($data['email'], $data['username'], $title, $content);

        $this->success('申请成功，请等待审核结果', url('bis/register/waiting', ['id' => $bisId]));
    }


    /**
     * 等待审核视图
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function waiting($id) {
        if(!$id) {
            return $this->error('页面不存在');
        }

        $field = ['id', 'name', 'status'];
        $bis = model('Bis')->where(['id' => $id])->field($field)->find();
        return $this->fetch('', ['bis' => $bis]);
    }

    /**
     * 异步获取经纬度
     * @param  [type] $address [description]
     * @return json          [description]
     */
    public function getLngLat($address){
        if(request()->isAjax()){
            $address = input('address');
        }

        $lngLat = \Map::getLngLat($address);
        ob_end_clean();
        if(empty($lngLat) || $lngLat['status'] != 0 || $lngLat['result']['precise'] != 1){
            return $this->result('', 1, '无法获取数据，或者匹配的地址不精确');
        }
        return $this->result($lngLat, 0, 'ok');
    }

    /**
     * 异步验证用户名
     * @param  [type] $username [description]
     * @return [type]           [description]
     */
    public function checkUsername($username){
        if(request()->isAjax()){
            $$username = input('username');
        }

        ob_end_clean();
        if(model('BisAccount')->where(['username' => $username])->value('id')){
            return $this->result('', 1, '用户名已存在');
        }
        return $this->result('', 0, 'ok');
    }
}