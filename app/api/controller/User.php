<?php
namespace app\api\controller;
use think\Db;
/**
*
*/
class User extends Base
{


	protected function before() {

		$this->db = Db::name('user');

	}

	public function getList()
	{
		$this->res = $this->db->select();
		return $this->ajaxReturn($this->code, $this->msg, $this->res);
	}

	public function getOne($id)
	{
		$this->res = $this->db->where('id',$id)->find();
		if($this->res) {

		} else {
			$this->msg = '用户不存在';
			$this->code = 1;
		}
		return $this->ajaxReturn($this->code, $this->msg, $this->res);
	}

	public function add()
	{
		$data = input();

		$this->res = $this->db->insert($data);
		return $this->ajaxReturn($this->code, $this->msg, $this->res);
	}

	public function loginOut() {
		session('ZM_USER_INFO_1',null);
		session('ZM_WX_OAUTH_INFO_1',null);
	}

	// 是否授权
  public function isOauth($url)
	{
    $token = $this->getToken();
    if (empty($token)){
			$this->code = 1001;
			$this->msg = '用户未授权';
			$weixin = new Weixin;
      $wxOauthBack = $weixin->getOauthUrl($url);
			$this->res = $wxOauthBack;
    } else {
			// $userInfo = $this->db->where('openid',$token['openid'])->find();
			// if ($userInfo) {
			// 	$this->setUserInfo($userInfo);
			// 	$this->res = $userInfo;
			// } else {
			// 	$this->code = 1002;
			// 	$this->res = $token;
			// }
			$this->res = $token;
			$this->msg = '用户已授权';
		}

    return $this->ajaxReturn($this->code, $this->msg, $this->res);
  }

	// 是否登陆
	public function isLogin() {

		$userInfo = $this->getUserInfo();
		if (empty($userInfo)){
			$this->code = 1002;
			$this->msg = '用户未登陆';
     } else {
			$this->res = $userInfo;
			$this->msg = '用户已登陆';
		}

		return $this->ajaxReturn($this->code, $this->msg, $this->res);
	}

	// 是否注册
	public function isRegister()
	{
		$userInfo = $this->getUserInfo();
		if (empty($userInfo)){
			$token = $this->getToken();
			$userInfo = $this->db->where('openid',$token['openid'])->find();
			if ($userInfo) {
				$this->setUserInfo($userInfo);
        $this->res = $userInfo;
      } else {
				$data['openid'] = $token['openid'];
				$data['nickname'] = $token['nickname'];
				$data['headimgurl'] = $token['headimgurl'];
				$data['sex'] = $token['sex'];
				$data['create_time'] = date('Y-m-d h:i:s', time());
				$this->db->insert($data);
				$userInfo = $this->db->where('openid',$token['openid'])->find();
				$this->setUserInfo($userInfo);
				$this->res = $userInfo;
				$this->msg = '恭喜您注册成功';
            }
        } else {
			$this->res = $userInfo;
			$this->msg = '您已登陆';
		}

		return $this->ajaxReturn($this->code, $this->msg, $this->res);
	}

	/**
	 * 注册
	 * @return [type] [description]
	 */
	public function register()
	{
		$data = input('post.');

		$userInfo = $this->getUserInfo();
		if (empty($userInfo)){
			$token = $this->getToken();
			if (empty($token)) {
				$this->code = 999;
				$this->msg = '未授权';
			} else {
				if (empty($data['name']) || empty($data['code']) || empty($data['mobile'])) {
					$this->code = 0;
					$this->msg = '必填项必须填写';
				} else if (strlen($data['mobile']) != 11) {
					$this->code = 0;
					$this->msg = '手机号格式不正确';
				} else if (strlen($data['code']) != 18) {
					$this->code = 0;
					$this->msg = '身份证格式不正确';
				} else {
					$dbdata['openid'] = $token['openid'];
					$dbdata['nickname'] = $token['nickname'];
					$dbdata['headimgurl'] = $token['headimgurl'];
					$dbdata['sex'] = $token['sex'];
					$dbdata['create_time'] = date('Y-m-d h:i:s', time());
					$dbdata['name'] = $data['name'];
					$dbdata['code'] = $data['code'];
					$dbdata['mobile'] = $data['mobile'];
					$this->db->insert($dbdata);
					$userInfo = $this->db->where('openid',$token['openid'])->find();
					$this->setUserInfo($userInfo);
					$this->res = $userInfo;
					$this->msg = '注册成功';
				}
			}
		} else {
			$this->msg = '重复注册';
		}

		return $this->ajaxReturn($this->code, $this->msg, $this->res);
	}

	function login() {
		$data = input('post.');

		$soap = new SoapClient("https://puser.zjzwfw.gov.cn/sso/service/SimpleAuthService?wsdl");

		$time = date('YmdHis');
		$sign = md5($this->servicecode.$this->servicepwd.$time);

		$paras['servicecode'] = $this->servicecode;
		$paras['time'] = $time;
		$paras['sign'] = $sign;
		$paras['encryptiontype'] = '1';
		$paras['loginname'] = $data['mobile'];
		$paras['password'] = $data['pwd'];
		$paras['datatype'] = 'json';

		$res = $soap->idValidation($paras);
	}
}