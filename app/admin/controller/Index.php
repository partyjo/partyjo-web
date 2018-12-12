<?php
namespace app\admin\controller;

class Index extends Base
{
	protected function before() {
		
	}

    public function index()
    {

        // 变量赋值
        $this->assign($this->res);
        // 模板输出
        return $this->fetch('index');
    }

}