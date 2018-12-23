<?php
namespace app\api\controller;
use SoapClient;

class Test extends ApiBase
{
	protected $servicecode;
	protected $servicepwd;

	public function index()
	{
		$aData = array(
			'name' => 'testdata',
			'email' => 'test123@163.com'
		);
		$aHeader = array('Content-Length: ' . strlen($aData)), 'language:zh');
		var_dump($aHeader);
		exit();
		//phpinfo();
		$this->servicecode = 'cxwxgz';
		$this->servicepwd = 'cxwxgzpwd';

		$soap = new SoapClient("https://puser.zjzwfw.gov.cn/sso/service/SimpleAuthService?wsdl");

		$time = date('YmdHis');
		$sign = md5($this->servicecode.$this->servicepwd.$time);

		$paras['servicecode'] = $this->servicecode;
		$paras['time'] = $time;
		$paras['sign'] = $sign;
		$paras['encryptiontype'] = '1';
		$paras['loginname'] = '13857277633';
		$paras['password'] = 'xtl6229718';
		$paras['datatype'] = 'json';

		$res = json_decode($soap->idValidation($paras)->out);
		dump($res->token);

		$paras1['servicecode'] = $this->servicecode;
		$paras1['time'] = $time;
		$paras1['sign'] = $sign;
		$paras1['token'] = $res->token;
		$paras1['datatype'] = 'json';
		$res = $soap->getUserInfo($paras1);
		dump($res);
		// $this->dataFiltering($res);
		// return $this->ajaxReturn($this->code, $this->msg, $this->data);
		//dump($this->data);
	}

	protected function postUrl($url, $data)
	{
	    $curl = curl_init(); // 启动一个CURL会话
	    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
	    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)'); // 模拟用户使用的浏览器
	    //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
	    //curl_setopt($curl, CURLOPT_AUTOREFERER, 1);    // 自动设置Referer
	    curl_setopt($curl, CURLOPT_POST, 1);             // 发送一个常规的Post请求
	    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));   // Post提交的数据包x
	    curl_setopt($curl, CURLOPT_TIMEOUT, 30);         // 设置超时限制 防止死循环
	    curl_setopt($curl, CURLOPT_HEADER, 0);           // 显示返回的Header区域内容
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   // 获取的信息以文件流的形式返回

	    $tmpInfo = curl_exec($curl); // 执行操作
	    if(curl_errno($curl))
	    {
	       echo 'Errno'.curl_error($curl);//捕抓异常
	    }
	    curl_close($curl); // 关闭CURL会话
	    return $tmpInfo; // 返回数据
	}
}