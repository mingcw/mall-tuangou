-- -----------------------------------------------------
-- 生活服务分类表
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hd_category`(
	`id` int UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名',
	`parent_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父分类ID。默认为0，表示顶级分类',
	`sort` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序值',
	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态值',
	`create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
	`update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
	PRIMARY KEY `id`(`id`),
	INDEX `parent_id`(`parent_id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='生活服务分类表';


-- -----------------------------------------------------
-- 城市表
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hd_city`(
	`id` int UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NOT NULL DEFAULT '' COMMENT '城市名',
	`enname` varchar(50) NOT NULL DEFAULT '' COMMENT '英文名',
	`is_default` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否默认城市',
	`parent_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父级城市ID。默认为0，表示一级城市',
	`sort` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序值',
	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态值',
	`create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
	`update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
	PRIMARY KEY `id`(`id`),
	INDEX `parent_id`(`parent_id`),
	UNIQUE KEY `enname`(`enname`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='城市表';


-- -----------------------------------------------------
-- 商圈表
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hd_area`(
	`id` int UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NOT NULL DEFAULT '' COMMENT '商圈名',
	`city_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属城市ID',
	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态值',
	`sort` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序值',
	`parent_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父ID',
	`create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
	`update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
	PRIMARY KEY `id`(`id`),
	INDEX `parent_id`(`parent_id`),
	INDEX `city_id`(`city_id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='商圈表';


-- -----------------------------------------------------
-- 商户表
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hd_bis`(
	`id` int UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NOT NULL DEFAULT '' COMMENT '商户名',
	`email` varchar(50) NOT NULL DEFAULT '' COMMENT '通知邮件',
	`logo` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
	`licence_logo` varchar(255) NOT NULL DEFAULT '' COMMENT '营业执照',
	`description` text NOT NULL COMMENT '商户介绍',
	`city_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '城市ID',
	`city_path` varchar(50) NOT NULL DEFAULT '' COMMENT '城市路径格式字符串："一级城市ID,二级城市ID" 或 "一级城市ID',
	`bank_account` varchar(50) NOT NULL DEFAULT '' COMMENT '银行账号',
	`money` decimal(20,0) NOT NULL DEFAULT '0' COMMENT '账号金额',
	`bank_name` varchar(50) NOT NULL DEFAULT '' COMMENT '开户行名称',
	`bank_user` varchar(50) NOT NULL DEFAULT '' COMMENT '开户人',
	`faren` varchar(50) NOT NULL DEFAULT '' COMMENT '法人',
	`faren_tel` varchar(50) NOT NULL DEFAULT '' COMMENT '法人联系方式',
	`sort` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序值',
	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态值',
	`create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
	`update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
	PRIMARY KEY `id`(`id`),
	INDEX `name`(`name`),
	INDEX `city_id`(`city_id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='商户表';


-- -----------------------------------------------------
-- 商户账号表
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hd_bis_account`(
	`id` int UNSIGNED NOT NULL AUTO_INCREMENT,
	`username` varchar(50) NOT NULL DEFAULT '' COMMENT '商户名',
	`password` varchar(50) NOT NULL DEFAULT '' COMMENT '密码',
	`code` varchar(255) NOT NULL DEFAULT '' COMMENT '加密KEY',
	`bis_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属商户ID',
	`last_login_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '上一次登录IP',
	`last_login_time` int(10) NOT NULL DEFAULT '0' COMMENT '上一次登录时间',
	`is_main` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否主账号',
	`sort` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序值',
	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态值',
	`create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
	`update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
	PRIMARY KEY `id`(`id`),
	INDEX `username`(`username`),
	INDEX `bis_id`(`bis_id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='商户账号表';



-- -----------------------------------------------------
-- 商户门店表
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hd_bis_location`(
	`id` int UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NOT NULL DEFAULT '' COMMENT '门店名',
	`logo` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
	`address` varchar(255) NOT NULL DEFAULT '' COMMENT '门店地址',
	`tel` varchar(20) NOT NULL DEFAULT '' COMMENT '联系电话',
	`contact_user` varchar(50) NOT NULL DEFAULT '' COMMENT '联系人',
	`x_point` varchar(20) NOT NULL DEFAULT '' COMMENT '所在经度',
	`y_point` varchar(20) NOT NULL DEFAULT '' COMMENT '所在纬度',
	`bis_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属商户ID',
	`open_time` varchar(30) NOT NULL DEFAULT '' COMMENT '营业时间',
	`introduce` text NOT NULL COMMENT '门店简介',
	`is_main` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否总店',
	`api_address` varchar(255) NOT NULL DEFAULT '' COMMENT '与address类似，可用两者之一',
	`city_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属城市ID',
	`city_path` varchar(50) NOT NULL DEFAULT '' COMMENT '城市路径格式字符串："一级城市ID,二级城市ID" 或 "一级城市ID',
	`category_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属分类ID',
	`category_path` varchar(50) NOT NULL DEFAULT '' COMMENT '分类ID字符串，格式字符串："一级分类ID,二级城市ID|二级分类ID|..." 或 "一级分类ID"',
	`bank_account` varchar(50) NOT NULL DEFAULT '' COMMENT '银行账号',
	`sort` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序值',
	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态值',
	`create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
	`update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
	PRIMARY KEY `id`(`id`),
	INDEX `name`(`name`),
	INDEX `bis_id`(`city_id`),
	INDEX `city_id`(`city_id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='商户门店表';


-- -----------------------------------------------------
-- 团购商品表
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hd_deal`(
	`id` int UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NOT NULL DEFAULT '' COMMENT '团购商品名',
	`category_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属分类ID',
	`se_category_id` varchar(100) NOT NULL DEFAULT '' COMMENT '二级分类ID串，","分割',
	`bis_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属商户ID',
	`location_ids` varchar(100) NOT NULL DEFAULT '' COMMENT '所属门店ID串，“,”分割',
	`image` varchar(200) NOT NULL DEFAULT '' COMMENT '缩略图',
	`description` text NOT NULL COMMENT '团购描述',
	`start_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '团购开始时间',
	`end_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '团购结束时间',
	`origin_price` decimal(20,0) NOT NULL DEFAULT '0' COMMENT '原价',
	`current_price` decimal(20,0) NOT NULL DEFAULT '0' COMMENT '团购价',
	`city_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属城市ID',
	`sell_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '出售数',
	`total_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '总数',
	`coupons_start_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '消费券生效时间',
	`coupons_end_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '消费券失效时间',
	`x_point` varchar(20) NOT NULL DEFAULT '' COMMENT '所在经度',
	`y_point` varchar(20) NOT NULL DEFAULT '' COMMENT '所在纬度',
	`bis_account_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属账号ID',
	`balance_price` decimal(20,0) NOT NULL DEFAULT '0' COMMENT '平台方收费',
	`notes` text NOT NULL COMMENT '购买须知',
	`sort` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序值',
	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态值',
	`create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
	`update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
	PRIMARY KEY `id`(`id`),
	INDEX `category_id`(`category_id`),
	INDEX `se_category_id`(`se_category_id`),
	INDEX `start_time`(`start_time`),
	INDEX `end_time`(`end_time`),
	INDEX `city_id`(`city_id`),
	INDEX `coupons_start_time`(`coupons_start_time`),
	INDEX `coupons_end_time`(`coupons_end_time`),
	INDEX `update_time`(`update_time`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='团购商品表';


-- ---------------------------------------------------
-- 用户表
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hd_user`(
	`id` int UNSIGNED NOT NULL AUTO_INCREMENT,
	`username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
	`password` varchar(50) NOT NULL DEFAULT '' COMMENT '密码',
	`code` varchar(255) NOT NULL DEFAULT '' COMMENT '加密KEY',
	`email` varchar(50) NOT NULL DEFAULT '' COMMENT '通知邮件',
	`mobile` varchar(50) NOT NULL DEFAULT '' COMMENT '联系电话',
	`last_login_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '上一次登录IP',
	`last_login_time` int(10) NOT NULL DEFAULT '0' COMMENT '上一次登录时间',
	`sort` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序值',
	`status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '状态值',
	`create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
	`update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
	PRIMARY KEY `id`(`id`),
	UNIQUE KEY `username`(`username`),
	UNIQUE KEY `email`(`email`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户表';


-- ---------------------------------------------------
-- 推荐位表
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hd_featured`(
	`id` int UNSIGNED NOT NULL AUTO_INCREMENT,
	`type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐位类型（在前台页面的位置标识）',
	`title` varchar(30) NOT NULL DEFAULT '' COMMENT '标题',
	`image` varchar(255) NOT NULL DEFAULT '' COMMENT '推荐图',
	`url` varchar(255) NOT NULL DEFAULT '' COMMENT 'url',
	`description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
	`sort` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序值',
	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态值',
	`create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
	`update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
	PRIMARY KEY `id`(`id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='推荐位表';


-- ---------------------------------------------------
-- 订单表
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hd_order`(
	`id` int UNSIGNED NOT NULL AUTO_INCREMENT,
	`out_trade_no` varchar(100) NOT NULL DEFAULT '' COMMENT '商户订单号',
	`transaction_id` varchar(100) NOT NULL DEFAULT '' COMMENT '微信订单号',
	`user_id` int NOT NULL DEFAULT '0' COMMENT '订单用户ID',
	`username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
	`pay_time` varchar(20) NOT NULL DEFAULT '' COMMENT '支付完成时间',
	`payment_mode` tinyint(1) NOT NULL DEFAULT '1' COMMENT '付款方式。默认为1微信\r\n支付。',
	`deal_id` int NOT NULL DEFAULT '0' COMMENT '商品ID',
	`deal_count` int(11) NOT NULL DEFAULT '0' COMMENT '下单商品数',
	`pay_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付状态,。默认为0。0未支付，1支付成功，2支付失败，3其他',
	`total_price` decimal(20,0) NOT NULL DEFAULT '0' COMMENT '总额',
	`pay_amount` decimal(20,0) NOT NULL DEFAULT '0' COMMENT '微信支付的返回总额',
	`referer` varchar(255) NOT NULL DEFAULT '' COMMENT '订单来源url',
	`sort` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序值',
	`status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态值',
	`create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
	`update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
	PRIMARY KEY `id`(`id`),
	UNIQUE `out_trade_no`(`out_trade_no`),
	INDEX `user_id`(`user_id`),
	INDEX `create_time`(`create_time`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='订单表';



-- ---------------------------------------------------
-- 消费券表
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hd_coupons`(
	`id` int UNSIGNED NOT NULL AUTO_INCREMENT,
	`sn` varchar(100) NOT NULL DEFAULT '' COMMENT '消费券序列号',
	`password` varchar(100) NOT NULL DEFAULT '' COMMENT '密码',
	`user_id` int NOT NULL DEFAULT '0' COMMENT '所属用户ID',
	`deal_id` int NOT NULL DEFAULT '0' COMMENT '商品ID',
	`order_id` int NOT NULL DEFAULT '0' COMMENT '订单ID',
	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态值。0生成未发送给用户，1已发送给用户，2用户已使用，3禁用',
	`create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
	`update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
	PRIMARY KEY `id`(`id`),
	UNIQUE `sn`(`sn`),
	INDEX `user_id`(`user_id`),
	INDEX `deal_id`(`deal_id`),
	INDEX `create_time`(`create_time`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='消费券表';
