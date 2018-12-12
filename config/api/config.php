<?php

return [
	// 默认Host地址
    'app_host'               => '',
    // 应用调试模式
    'app_debug'              => true,
    // 应用Trace
    'app_trace'              => true,
    // 应用模式状态
    'app_status'             => '',
    // 默认输出类型
    'default_return_type'    => 'json',
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return'    => 'json',
    // 默认JSONP格式返回的处理方法
    'default_jsonp_handler'  => 'jsonpReturn',
    // 默认JSONP处理方法
    'var_jsonp_handler'      => 'callback',
    // 默认全局过滤方法 用逗号分隔多个
    'default_filter'         => 'htmlspecialchars',

    //微信配置
    'wxconfig_nanhu'               => [
        'token'=>'Th4ZHH5Ck1mKh77x4KKQMSO555skX71p', //填写你设定的key
        'encodingaeskey'=>'XZXBA1l9Bh1Xelt96TBxHyTE19UA8x6LB7tAzGbeYrl', //填写加密用的EncodingAESKey
        'appid'=>'wx4a19276884cf84e2', //填写高级调用功能的app id
        'appsecret'=>'456ae28cc1377a54bfe9929824ecb09e' //填写高级调用功能的密钥
    ],

];