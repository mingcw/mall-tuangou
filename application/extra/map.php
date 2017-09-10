<?php
/**
 * 百度地图API相关配置
 */
return [
	'domain_name' =>       'http://api.map.baidu.com',         // 域名
	'ak'          =>       'K8pARWOdgyHnHpY1mbzSK8DGzC4PPLWh', // ak 秘钥

	 // Geocoding API配置
	'geocoder'    =>       'geocoder',       // Geocoding服务名
	'geo_ver'     =>       'v2',             // 版本号
	'output'      =>       'json',

	 // 静态图API配置
	'staticimage' =>       'staticimage',    // 静态图服务名
	'static_ver'  =>       'v2',             // 版本号
	'width'       =>       400,              // 图片宽度。取值范围：(0, 1024]。Scale=2,取值范围：(0, 512]。
	'height'      =>       300,              // 图片高度。取值范围：(0, 1024]。Scale=2,取值范围：(0, 512]。
	'zoom'        =>       11,               // 地图级别。高清图范围[3, 18]；低清图范围[3,19]
];
