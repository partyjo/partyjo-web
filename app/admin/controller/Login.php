<?php
namespace app\admin\controller;
use think\Controller;

class Login extends Controller
{
    protected function _initialize()
    {
        
    }
    public function index()
    {
        return $this->fetch();
    }
    public function loginIn()
    {
        $data = input();
        
        if ($data['admin_user'] == 'admin' && $data['admin_pwd'] == '123456') {
            return $this->success('登录成功','admin/index/index');
        }
        return $this->error('帐号或密码错误');
    }

}