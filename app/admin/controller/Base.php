<?php
namespace app\admin\controller;
use think\Controller;

class Base extends Controller
{
    protected $res; //模型中所有返回数据的集合
    protected $isAjax;

    protected $code; // 返回码
    protected $msg; // 返回信息
    protected $data; // 返回数据

    /**
     * @cc 验证登录和操作权限
     * @return [type] [description]
     */
    protected function _initialize()
    {
        $this->res = [];
        $this->isAjax = request()->isAjax();
        $this->view->engine->layout('Layout');

        $this->code = 1;
        $this->msg = '';
        $this->data = null;

    	//未登录状态跳转到登录页面
        $this->res['loginUser'] = $this->isLogin();
        // if ($this->res['loginUser'] === false) {
        // 	return $this->redirect(url('admin/login/index'));
        // }
        $this->before();
    }

    protected function before() {

	}

    /**
     * @cc 是否登录
     * @return [type] [description]
     */
    protected function isLogin()
    {
        //return ['uid'=>'1'];
        if (!empty($this->getLoginUser())) {
            return $this->getLoginUser();
        }
        if (!empty($this->getCookie())) {
            $admin = model('auth_user')->getByToken($this->getCookie());
            if ($admin) {
                $this->setLoginUser($admin);
                return $admin;
            }
            return false;
        }
        return false;
    }
    protected function setLoginUser($data)
    {
        session(config('ident')['auth_user_login'],$data);
    }
    protected function getCookie()
    {
        return cookie(config('ident')['auth_user_token']);
    }
    protected function getLoginUser()
    {
        return session(config('ident')['auth_user_login']);
    }

    /**
     * ajax返回数据
     * @param  integer $code  [description]
     * @param  string  $msg   [description]
     * @param  [type]  $data  [description]
     * @param  [type]  $total [description]
     * @return [type]         [description]
     */
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

}