## mall-tuangou

仿百度糯米的O2O商城——MALL团购网

> 更新中...

## 整理和优化

1. 使用到的`PHP`第三方依赖均使用`Composer`管理

    * [PHPMailer/PHPMailer](https://github.com/PHPMailer/PHPMailer)
    * [top-think/think-captcha](https://github.com/top-think/think-captcha)

2. 扩展类库目录`extend`下封装个人类库

    * 百度地图服务类`extend/Map.php`：使用[百度地图API](http://lbsyun.baidu.com/)实现，相关配置在扩展配置目录`application/extra/map.php.example`文件，拷贝后去掉`.example`后缀。详细配置参考百度开放平台相关服务。
    * 邮件服务类`extend/Mail.php`：使用[PHPMailer](https://github.com/PHPMailer/PHPMailer)实现，相关配置在扩展配置目录`application/extra/mail.php.example`文件 ，拷贝后去掉`.example`后缀。详细配置参考[点这里](https://github.com/PHPMailer/PHPMailer/blob/master/class.phpmailer.php)

3. 扩展配置文件

    * 在`application/extra`目录下有几个扩展配置文件：

        * featured.php - 推荐位配置文件
        * mail.php.example - 邮件服务类配置文件（拷贝后去掉`.example`后缀）
        * map.php.example - 百度地图服务类配置文件（拷贝后去掉`.example`后缀）
        * web.php - 站点配置文件

4. 邮件通知
   
    * 商户模块中，有关商户注册、门店新增、团购商品新增，需要平台方审核，使用邮件通知告知商户

    * 主平台模块中，有关商户审核、门店申请、团购商品提交，以及状态值修改，涉及审核结果的及时通知，使用邮件通知告知商户

5. 过滤非法数据
    
    * 几乎所有`CRUD`操作均使用了验证器`Validate`，统一整合在公共模块验证器目录下`application/common/validate`

6. SQL优化

    * 数据表操作主要使用`DB`的方法
    * 字段过滤查询，主要使用`DB`的`field`方法
    * ......

7. 个人的所有自定义函数在`application/common.php`文件

    * 定义了较多的自定义函数，譬如加密解密函数，统一了加密逻辑

8. 商户模块的`Session`用`Redis`存储，配置参数在商户模块配置文件`application/bis/config.php`

9. 原教材的部分Bug修正

    * 商户模块中添加商品，如果只选择一级城市，提交的城市ID会被二级城市默认0覆盖
    * 其他一、两处不记得

10. 原教材的部分不合理逻辑修正（个人看法）

    * 主平台模块的推荐位列表不直接显示所有类型的推荐位，需要手动切换
    * 服务端返回数据的函数封装，直接返回了PHP数组，至少在我的机器上始终报错，前端JS接收异常
    * 商户模块的前台用户注册验证码部分，直接修改了`vendor`目录里`think-captcha`包的源代码
    * 其他一、两处不记得

11. 数据库表结构做了微调

## 必要的说明

1. 部分前端资源现未上传

    * 后台模板框架`H-ui.admin`所需文件未上传（太大），所以`public/static/admin/h-ui-admin`目录下为空

## 测试账号密码

   | 账号 | 密码 | 角色 |
   |------|-----------|------|
   | 李雷 | ll11111111 | 商户 |
   | 韩梅梅 | hmm11111111 | 商户 |
   | 王雪 | wx11111111 | 商户 |
   | 林立 | ll11111111 | 商户 |
