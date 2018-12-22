<?php
namespace app\api\controller;

class Task extends ApiBase
{

	public function getLobby()
	{
		$url = $this->apis['GetLobby'];
		$res = $this->handle($this->postUrl($url,$this->paras));
		if ($res['code'] == 1) {
			$this->data = $res['data']['halllist'];
		} else {
			$this->code = 101;
      $this->msg = $res['msg'];
		}

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	public function getTaskKindOU()
	{
		$this->paras['params']['hallguid'] = input('lobbyType');
		$this->paras['params']['shownum'] = input('pageSize') ? input('pageSize'): 10;

		$url = $this->apis['GetTaskKindOU'];
		$res = $this->handle($this->postUrl($url,$this->paras));
		if ($res['code'] == 1) {
			$this->data = $res['data']['themelist'];
		} else {
			$this->code = 101;
      $this->msg = $res['msg'];
		}

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	public function getTaskList()
	{
		$data = input('');

		if (!isset($data['oUGuid']) || empty($data['oUGuid'])) {
			$this->code = 0;
			$this->msg = '缺少参数';
		} else {
			$this->paras['params']['themeguid'] = $data['oUGuid'];
			$this->paras['params']['shownum'] = isset($data['pageSize']) ? $data['pageSize'] : 10;
			$url = $this->apis['GetTaskList'];
			$res = $this->handle($this->postUrl($url,$this->paras));
			if ($res['code'] == 1) {
				$this->data = $res['data']['themelist'];
			} else {
				$this->code = 101;
				$this->msg = $res['msg'];
			}
		}
	
		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	public function getTaskDetail()
	{
		$data = input('post.');
		$paras = '';

		if (!isset($data['taskGuid']) || empty($data['taskGuid'])) {
			$this->code = 0;
			$this->msg = '缺少参数';
		} else {
			$paras['taskGuid'] = $data['taskGuid'];
			$this->paras['paras'] = $paras;
			$url = $this->apis['GetTaskDetail'];
			$res = $this->postUrl($url,$this->paras);
			$this->dataFiltering($res);
		}

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

}