<?php
namespace app\api\controller;
use think\Controller;
use think\Request;
use think\Db;

header('Access-Control-Allow-Origin:*');  
// 响应类型  
header('Access-Control-Allow-Methods:*');  
// 响应头设置  
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class Base extends Controller
{
    protected $debug = true;

    protected $openid;
    protected $url;
    protected $paras;

    protected $requestData; // 请求api的参数
    protected $code; // 返回码
    protected $msg; // 返回信息
    protected $res; // 返回数据

    /**
     * @cc 验证登录和操作权限
     * @return [type] [description]
     */
    protected function _initialize()
    {
        $this->code = 1;
        $this->msg = '';
        $this->res = null;
        //$this->total = 0;
        $this->openid = $this->getOpenid();
        $this->url = $this->getRequestInfo();
        //$this->paras = $this->getParas();
    	//未登录状态跳转到登录页面
        //$this->res['loginUser'] = $this->isLogin();
        // if ($this->res['loginUser'] === false) {
        // 	return $this->redirect(url('admin/login/index'));
        // }
        $this->before();
    }

    protected function before() {

	}

    protected function getOpenid() {

        if (input('get.openid')) {
            $userInfo = Db::name('user')->where('openid',input('get.openid'))->find();
            $this->setUserInfo($userInfo);

        }

        return $this->getUserInfo()?$this->getUserInfo()['openid']:'';
    }

    protected function getRequestInfo() {
        $res = [];
        $request = Request::instance();

        $res['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
        $res['ROOT'] = $request->root();

        return $res;
    }

    protected function getParas() {
        $res = [];
        $request = Request::instance();


        return $request;
    }

    protected function ajaxReturn($code = 1, $msg = '', $data = null, $total = null)
    {
        $res = [];

        $res['ret'] = $code;

        if ($msg == '') {
            $res['msg'] = '操作成功';
        } else {
            $res['msg'] = $msg;
        }

        if(!is_null($data)) {
            $res['data'] = $data;
        }

        if(!is_null($total)) {
            $res['total'] = $total;
        }

        return $res;
    }


    //获取登陆信息
    protected function getUserInfo()
    {
    	return session('ZM_USER_INFO');
    }
    //存储登陆信息
    protected function setUserInfo($info)
    {
    	return session('ZM_USER_INFO',$info);
    }
    //获取授权信息
    protected function getToken()
    {
        // if ($this->debug) {
        //     return [
        //         'openid'=>'o9-y-0zpSkPbcDqRpUel0kK50Adc',
        //         'nickname'=>'阿敏',
        //         'headimgurl'=>'http://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eo3yW0arVaSoatJVz8AHdyW59tia3HJHk2s5sP9v6o3JpBqN1Hm8jSgNDxPwgxhwV42USic22PZPnDw/0',
        //         'sex'=>1
        //     ];
        // }
        return session('ZM_WX_OAUTH_INFO');
    }

}