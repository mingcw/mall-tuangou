<?php
//配置文件
return [
    
    // 商户模块session配置
    'session'                => [
        'type'           => 'redis', // Redis驱动存储商户模块的所有Session
        'prefix'         => 'bis',
        'auto_start'     => true,

        // Redis连接参数
        'host'       => '127.0.0.1',
        'port'       => 6379,
        'password'   => '',
    ],
];