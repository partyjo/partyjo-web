<?php
namespace app\api\controller;

class Project extends ApiBase
{

	public function getProjectByFlowSN()
	{
		$data = input('post.');
		$paras = '';

		if (!isset($data['flowSN'])) {
			$this->code = 0;
			$this->msg = '缺少参数';
		} else {
			$paras['FlowSN'] = $data['flowSN'];
			$this->paras['paras'] = $paras;
			$url = $this->apis['GetProjectByFlowSN'];
			$res = $this->postUrl($url,$this->paras);
			$this->dataFiltering($res);
			if (empty($this->data['ProjectGuid'])) {
				$this->code = 0;
				$this->msg = '不存在的流水号';
			}
		}

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	public function getProjectDetail()
	{
		$data = input('post.');
		$paras = "";

		if (!isset($data['projectGuid'])) {
			$this->code = 0;
			$this->msg = '不存在的办件编号';
		} else {
			$paras['ProjectGuid'] = $data['projectGuid'];
			$this->paras['paras'] = $paras;
			$url = $this->apis['GetProjectDetail'];
			$res = $this->postUrl($url,$this->paras);
			$this->dataFiltering($res);

		}

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

}