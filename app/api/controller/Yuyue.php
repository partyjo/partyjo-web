<?php
namespace app\api\controller;

class Yuyue extends ApiBase
{

	public function getTaskKindOU_YY()
	{
		$paras['LobbyType'] = $paras['LobbyType'] = empty(input('post.lobbyType'))?'':input('post.lobbyType');;
		$this->paras['paras'] = $paras;

		$url = $this->apis['GetTaskKindOU_YY'];
		$res = $this->postUrl($url,$this->paras);
		$this->dataFiltering($res);

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	public function getTaskList_YY()
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
			$url = $this->apis['GetTaskList_YY'];
			$res = $this->postUrl($url,$this->paras);
			$this->dataFiltering($res);
		}

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	public function getYuYueDateList()
	{
		$data = input('post.');
		$paras = "";

		$paras['ShowDays'] = isset($data['showDays'])?$data['showDays']:5;
		$this->paras['paras'] = $paras;
		$url = $this->apis['GetYuYueDateList'];
		$res = $this->postUrl($url,$this->paras);
		$this->dataFiltering($res);

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	public function getYuYueTimeList()
	{
		$data = input('post.');
		$paras = "";

		if (!isset($data['taskGuid']) || !isset($data['yuYueDate'])) {
			$this->code = 0;
			$this->msg = '缺少参数';
		} else {
			$paras['TaskGuid'] = $data['taskGuid'];
			$paras['YuYueDate'] = $data['yuYueDate'];
			$this->paras['paras'] = $paras;
			$url = $this->apis['GetYuYueTimeList'];
			$res = $this->postUrl($url,$this->paras);
			$this->dataFiltering($res);
		}

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	public function getYuYueQNO()
	{
		$data = input('post.');
		$paras = "";

		if (empty($this->userInfo)) {
			$this->code = 999;
			$this->msg = '未授权';
			return $this->ajaxReturn($this->code, $this->msg, $this->data);
		}

		if (!isset($data['taskGuid']) || !isset($data['date']) || !isset($data['st']) || !isset($data['et'])) {
			$this->code = 0;
			$this->msg = '缺少参数';
		} else {
			$paras['TaskGuid'] = $data['taskGuid'];
			$paras['UserGuid'] = '';
			$paras['UserName'] = $this->userInfo['name'];
			$paras['IdentityCardID'] = $this->userInfo['code'];
			$paras['Mobile'] = $this->userInfo['mobile'];
			$paras['YuYueTimeStart'] = $data['st'];
			$paras['YuYueTimeEnd'] = $data['et'];
			$paras['YuYueDate'] = $data['date'];

			$this->paras['paras'] = $paras;
			$url = $this->apis['GetYuYueQNO'];
			$res = $this->postUrl($url,$this->paras);
			$this->dataFiltering($res);
		}
		if ($this->code == 1) {
			$this->msg = '预约成功';
		}
		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	public function getAppointmentList()
	{
		$data = input('post.');
		$paras = "";

		if (empty($this->userInfo)) {
			$this->code = 999;
			$this->msg = '未授权';
			return $this->ajaxReturn($this->code, $this->msg, $this->data);
		}

		$paras['IDCardNO'] = $this->userInfo['code'];
		$paras['Phone'] = $this->userInfo['mobile'];
		$paras['ShowType'] = isset($data['showType'])?$data['showType']:'';
		$paras['CurrentPageIndex'] = isset($data['pageIndex'])?$data['pageIndex']:1;
		$paras['PageSize'] = isset($data['pageSize'])?$data['pageSize']:10;

		$this->paras['paras'] = $paras;
		//dump($this->paras);
		$url = $this->apis['GetAppointmentList'];
		$res = $this->postUrl($url,$this->paras);
		$this->dataFiltering($res);

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}
}