# mall-tuangou

仿百度糯米的O2O商城——MALL团购网

> 正在写...

# 说明

1. 扩展类库目录`extend`下封装个人类库

	[百度地图API](http://lbsyun.baidu.com/)

	邮件服务类（使用[PHPMailer](https://github.com/PHPMailer/PHPMailer)）

2. 使用到的第三方依赖均使用`Composer`管理

	[PHPMailer](https://github.com/PHPMailer/PHPMailer)

3. 邮件服务相关配置

	`application/extra/mail.php.example` 是邮件服务的参数配置文件，拷贝后去掉`.example`。详细配置参考[点这里](https://github.com/PHPMailer/PHPMailer/blob/master/class.phpmailer.php)

4. 部分前端资源现未上传

	后台模板框架`H-ui.admin`所需文件未上传（太大），所以`public/static/admin/h-ui-admin`目录下为空

5. 测试账号密码

	| 账号 | 密码 | 角色 |
	|------|-----------|------|
	| 李雷 | ll11111111 | 商户 |
	| 韩梅梅 | hmm11111111 | 商户 |
	| 王雪 | wx11111111 | 商户 |
	| 林立 | ll11111111 | 商户 |
