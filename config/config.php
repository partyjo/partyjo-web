<?php

return [
	// 默认Host地址
    'app_host'               => '',
    // 应用调试模式
    'app_debug'              => false,
    // 应用Trace
    'app_trace'              => false,
    // 应用模式状态
    'app_status'             => '',
    // 默认输出类型
    'default_return_type'    => 'html',
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return'    => 'json',
    // 默认JSONP格式返回的处理方法
    'default_jsonp_handler'  => 'jsonpReturn',
    // 默认JSONP处理方法
    'var_jsonp_handler'      => 'callback',
    // 默认全局过滤方法 用逗号分隔多个
    'default_filter'         => 'htmlspecialchars',

    // 视图输出字符串内容替换
    'view_replace_str'       => [
        '__PUBLIC__' => '/partyjo-web/public'
    ],

    'auto_timestamp' => 'datetime',

    //微信配置
    'wxconfig_nanhu'               => [
        'token'=>'Th4ZHH5Ck1mKh77x4KKQMSO555skX71p', //填写你设定的key
        'encodingaeskey'=>'XZXBA1l9Bh1Xelt96TBxHyTE19UA8x6LB7tAzGbeYrl', //填写加密用的EncodingAESKey
        'appid'=>'wxa1f31403c522cb9e', //填写高级调用功能的app id
        'appsecret'=>'d672fafa0a5dc27bc66ed87e1cfee8a9' //填写高级调用功能的密钥
    ],
    // 'wxconfig'               => [
    //     'token'=>'shark', //填写你设定的key
    //     'encodingaeskey'=>'k5FTgeKofB8LQtNdi1qrxlm9KqyDGZQumsLBJ1wznXb', //填写加密用的EncodingAESKey
    //     'appid'=>'wx1a9b89f3e4abbb5e', //填写高级调用功能的app id
    //     'appsecret'=>'f9691183d68c858ce5e7b451924c225d' //填写高级调用功能的密钥
    // ],

];