<?php
namespace app\admin\controller;
use think\Db;

class User extends Base
{
    protected $db;

	protected function before() {
		
        $this->db = Db::name('user');
        
	}

    public function index()
    {
        $list = $this->db->order('create_time desc')->paginate(10);
        $total = $this->db->count();
        $page = $list->render();

        $this->res['list'] = $list;
        $this->res['total'] = $total;
        $this->res['page'] = $page;
        
        // 变量赋值
        $this->assign($this->res);
        // 模板输出
        return $this->fetch('index');
    }

    public function add()
    {
        
        // 变量赋值
        $this->assign($this->res);
        // 模板输出
        $this->view->engine->layout('Layout_add');
        return $this->fetch('add');
    }

    public function edit($id)
    {
        $this->res['data'] = $this->db->where('id',$id)->find();
        // 变量赋值
        $this->assign($this->res);
        // 模板输出
        $this->view->engine->layout('Layout_add');
        return $this->fetch('edit');
    }

}