<?php
namespace app\api\controller;
use think\Db;
/**
*
*/
class Menu extends Base
{
	protected function before() {

		$this->db = Db::name('menu');
	}

	public function getList()
	{
		$type = input('post.type');

		$map['type'] = $type;
		$map['status'] = 1;

		if (isset($data['pageIndex']) && isset($data['pageSize'])) {
			$pageIndex = empty($data['pageIndex'])?1: $data['pageIndex'];
			$pageSize = empty($data['pageSize'])?10: $data['pageSize'];
			$this->res = $this->db->where($map)->limit($pageIndex,$pageSize)->select();
		} else {
			$this->res = $this->db->where($map)->select();
		}

		return $this->ajaxReturn($this->code, $this->msg, $this->res);
	}

	public function getOne($id)
	{
		$this->res = $this->db->where('id',$id)->find();
		return $this->ajaxReturn($this->code, $this->msg, $this->res);
	}

}