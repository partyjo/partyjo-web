<?php
namespace app\admin\controller;
use think\Db;

class Menu extends Base
{
    protected $db;

	protected function before() {
        $this->db = Db::name('menu');
	}

    public function banner()
    {
        $map['type'] = 'banner';
        $this->res['list'] = $this->db->where($map)->select();
        // 变量赋值
        $this->assign($this->res);
        // 模板输出
        return $this->fetch('banner');
    }

    public function cate()
    {
        $map['type'] = 'cate';
        $this->res['list'] = $this->db->where($map)->select();
        // 变量赋值
        $this->assign($this->res);
        // 模板输出
        return $this->fetch('cate');
    }

    public function app()
    {
        $map['type'] = 'app';
        $this->res['list'] = $this->db->where($map)->select();
        // 变量赋值
        $this->assign($this->res);
        // 模板输出
        return $this->fetch('app');
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


    public function save()
    {
        $data = input('post.');
        if (!isset($data['type'])) {
           $this->code = 0;
           $this->msg = '页面出错';
        } else {
            if (isset($data['id'])) {
               $this->data = $this->db->update($data);
            } else {
                $this->data = $this->db->insert($data);
            }
        }

        return $this->ajaxReturn($this->code, $this->msg, $this->data);
    }

    public function del()
    {
        $id = input('post.id');
        $this->data = $this->db->delete($id);
        if ($this->data) {
            $this->msg = '删除成功';
        }
        return $this->ajaxReturn($this->code, $this->msg, $this->data);
    }

}