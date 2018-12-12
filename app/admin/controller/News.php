<?php
namespace app\admin\controller;
use think\Db;

class News extends Base
{
    protected $db;

	protected function before() {

        $this->db = Db::name('news');

	}

    public function index()
    {
        $list = $this->db->order('id desc')->paginate(10);
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

    public function save()
    {
        $data = input('post.');
        if (isset($data['id'])) {
           $this->data = $this->db->update($data);
        } else {
            $this->data = $this->db->insert($data);
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