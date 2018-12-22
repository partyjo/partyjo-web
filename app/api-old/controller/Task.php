<?php
namespace app\api\controller;

class Task extends ApiBase
{

	public function getLobby()
	{
		$url = $this->apis['GetLobby'];
		$res = $this->postUrl($url,$this->paras);
		$this->dataFiltering($res);

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	public function getTaskKindOU()
	{
		$paras['LobbyType'] = empty(input('post.lobbyType'))?'':input('post.lobbyType');
		$this->paras['paras'] = $paras;

		$url = $this->apis['GetTaskKindOU'];
		$res = $this->postUrl($url,$this->paras);
		$this->dataFiltering($res);

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	public function getTaskList()
	{
		$data = input('post.');
		$paras = "";

		if (!isset($data['oUGuid']) || empty($data['oUGuid'])) {
			$this->code = 0;
			$this->msg = '缺少参数';
		} else {
			$paras['OUGuid'] = $data['oUGuid'];
			$paras['CurrentPageIndex'] = isset($data['pageIndex'])?$data['pageIndex']:1;
			$paras['PageSize'] = isset($data['pageSize'])?$data['pageSize']:10;
			$this->paras['paras'] = $paras;
			$url = $this->apis['GetTaskList'];
			$res = $this->postUrl($url,$this->paras);
			$this->dataFiltering($res);
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