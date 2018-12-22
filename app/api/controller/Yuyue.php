<?php
namespace app\api\controller;

class Yuyue extends ApiBase
{

	public function getTaskKindOU_YY()
	{
		$paras['LobbyType'] = $paras['LobbyType'] = empty(input('lobbyType'))?'':input('lobbyType');;
		$this->paras['paras'] = $paras;

		$url = $this->apis['GetTaskKindOU_YY'];
		$res = $this->postUrl($url,$this->paras);
		$this->dataFiltering($res);

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	public function getTaskList_YY()
	{
		$data = input('');
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
		$data = input('');

		$this->paras['params']['showdays'] = isset($data['showDays'])?$data['showDays']:10;
		$url = $this->apis['GetYuYueDateList'];
		$res = $this->handle($this->postUrl($url,$this->paras));
		if ($res['code'] == 1) {
			$this->data = $res['data']['appointdatelist'];
		} else {
			$this->code = 101;
      $this->msg = $res['msg'];
		}

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	public function getYuYueTimeList()
	{
		$data = input('');

		if (!isset($data['taskGuid'])) {
			$this->code = 0;
			$this->msg = '缺少参数 taskGuid';
		} else if (!isset($data['yuYueDate'])) {
			$this->code = 0;
			$this->msg = '缺少参数 yuYueDate';
		} else {
			$this->paras['params']['taskguid'] = $data['taskGuid'];
			$this->paras['params']['appointdate'] = $data['yuYueDate'];
			$this->paras['params']['accountguid'] = '347ec973-930c-4815-9941-fdfc6df518df';
			
			$url = $this->apis['GetYuYueTimeList'];
			$res = $this->handle($this->postUrl($url,$this->paras));
			if ($res['code'] == 1) {
				$this->data = $res['data']['appointdatelist'];
			} else {
				$this->code = 101;
				$this->msg = $res['msg'];
			}
		}

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	public function getAppointDetail() {
		$url = $this->apis['getAppointDetail'];
		$res = $this->handle($this->postUrl($url,$this->paras));
		if ($res['code'] == 1) {
			$this->data = $res['data']['appointdatelist'];
		} else {
			$this->code = 101;
			$this->msg = $res['msg'];
		}
		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	public function Getwaitnumbytime() {
		
		if (empty(input('taskGuid'))) {
			$this->code = 0;
			$this->msg = '缺少参数:taskGuid';
		} else {
			$this->paras['params']['taskguid'] = input('taskGuid');
			$url = $this->apis['getWaitNumbyTime'];
			$res = $this->handle($this->postUrl($url,$this->paras));
			if ($res['code'] == 1) {
				$this->data = $res['data']['waitnumlist'];
			} else {
				$this->code = 101;
				$this->msg = $res['msg'];
			}
		}
		
		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	public function getYuYueQNO()
	{
		$data = input('');

		if (empty($this->userInfo)) {
			$this->code = 999;
			$this->msg = '未授权';
			return $this->ajaxReturn($this->code, $this->msg, $this->data);
		}

		if (!isset($data['taskGuid']) || !isset($data['date']) || !isset($data['st']) || !isset($data['et'])) {
			$this->code = 0;
			$this->msg = '缺少参数';
		} else {
			$this->paras['params']['taskguid'] = $data['taskGuid'];
			$this->paras['params']['accountguid'] = '';
			$this->paras['params']['appointtype'] = isset($data['type']) ? $data['type'] : 2;
			$this->paras['params']['username'] = $this->userInfo['name'];
			$this->paras['params']['identitycardid'] = $this->userInfo['code'];
			$this->paras['params']['mobile'] = $this->userInfo['mobile'];
			$this->paras['params']['appointtimestart'] = $data['st'];
			$this->paras['params']['appointtimeend'] = $data['et'];
			$this->paras['params']['appointdate'] = $data['date'];

			$url = $this->apis['GetYuYueQNO'];
			$res = $this->handle($this->postUrl($url,$this->paras));
			if ($res['code'] == 1) {
				$this->data = $res['data'];
			} else {
				$this->code = 101;
				$this->msg = $res['msg'];
			}
		}
		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	public function getAppointmentList()
	{
		$data = input('');
		$paras = "";

		if (empty($this->userInfo)) {
			$this->code = 999;
			$this->msg = '未授权';
			return $this->ajaxReturn($this->code, $this->msg, $this->data);
		}

		$this->paras['params']['accountguid'] = '';
		$this->paras['params']['Phone'] = $this->userInfo['mobile'];
		$this->paras['params']['type'] = isset($data['showType']) ? $data['showType'] : 2;
		$this->paras['params']['currentpage'] = isset($data['pageIndex'])?$data['pageIndex']:1;
		$this->paras['params']['pagesize'] = isset($data['pageSize'])?$data['pageSize']:10;
		
		$url = $this->apis['GetAppointmentList'];
		$res = $this->handle($this->postUrl($url,$this->paras));
		if ($res['code'] == 1) {
			$this->data = $res['data'];
		} else {
			$this->code = 101;
			$this->msg = $res['msg'];
		}

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}
}