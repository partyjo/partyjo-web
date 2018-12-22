<?php
namespace app\api\controller;
use think\Db;

class Login extends ApiBase
{

	public function before()
	{
		$this->servicecode = 'cxwxgz';
		$this->servicepwd = 'cxwxgzpwd';
		$this->db = Db::name('user');
	}

	public function getAppUserInfo() {
		$url = $this->apis['getAppUserinfo'];
		$this->paras['nxwxticket'] = 'b309ffca-7331-431e-a5f3-ff04523c4852';
		$res = $this->handle($this->postUrl($url,$this->paras));
		if ($res['code'] == 1) {
			$this->data = $res['data'];
		} else {
			$this->code = 101;
      $this->msg = $res['msg'];
		}

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	public function index()
	{
		$ticket = input('post.ticket');
		//$ticket = '8afac2ed6069c81501606f571e763a70-ticket';
		$time = date('YmdHis');
		$sign = md5($this->servicecode.$this->servicepwd.$time);

		$url = 'https://puser.zjzwfw.gov.cn/sso/servlet/simpleauth?method=ticketValidation&servicecode='.$this->servicecode.'&time='.$time.'&sign='.$sign.'&datatype=json&st='.$ticket;

		$res = json_decode($this->postUrl($url,[]),true);
		if ($res['result'] != 0) {
			$this->code = 0;
			$this->msg = $res['errmsg'];
		} else {
			$userinfo = $this->getInfo($res['token']);
			if ($userinfo['result'] != 0) {
				$this->code = 0;
				$this->msg = $userinfo['errmsg'];
			} else {
				$this->data = $this->register($userinfo);
				$this->msg = '登陆成功';
			}
		}

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	protected function getInfo($token)
	{

		$time = date('YmdHis');
		$sign = md5($this->servicecode.$this->servicepwd.$time);
		$url = 'https://puser.zjzwfw.gov.cn/sso/servlet/simpleauth?method=getUserInfo&servicecode='.$this->servicecode.'&time='.$time.'&sign='.$sign.'&datatype=json&token='.$token;


		return json_decode($this->postUrl($url,[]),true);
	}

	protected function register($user)
	{
		$userInfo = $this->getUserInfo();
		if (empty($userInfo)){
			$token = $this->getToken();
			$userInfo = $this->db->where('openid',$token['openid'])->find();
			if ($userInfo) {
				$this->setUserInfo($userInfo);
                $res = $userInfo;
            } else {
				$data['openid'] = $token['openid'];
				$data['nickname'] = $token['nickname'];
				$data['headimgurl'] = $token['headimgurl'];
				$data['sex'] = $token['sex'];
				$data['create_time'] = date('Y-m-d h:i:s', time());

				$data['name'] = $user['username'];
				$data['mobile'] = $user['mobile'];
				$data['code'] = $user['idnum'];

				$this->db->insert($data);
				$userInfo = $this->db->where('openid',$token['openid'])->find();
				$this->setUserInfo($userInfo);
				$res = $userInfo;
            }
        } else {
			$res = $userInfo;
			return $res;
		}

		return $userInfo;
	}

	public function login2()
	{

		$username = input('post.loginname');
		$password = input('post.loginpwd');

		$url1 = 'https://esso.zjzwfw.gov.cn/tgssocheck/appLogin?username='.$username.'&password='.$password;
		$res1 = json_decode($this->postUrl($url1,[]),true);
		//dump($res1);

		if ($res1['errCode'] != 0) {
			$this->code = 0;
			$this->msg = $res1['msg'];
		} else {
			$url2 = 'https://esso.zjzwfw.gov.cn/tgssocheck/getLoginInfo?ssotoken='.$res1['ssotoken'];
			$res2 = json_decode($this->postUrl($url2,[]),true);
			//dump($res2);

			if ($res2['errCode'] != 0) {
				$this->code = 0;
				$this->msg = $res2['msg'];
			} else {
				$this->data = $this->register2($res2['info']);
				$this->msg = '登陆成功';
			}
		}

		return $this->ajaxReturn($this->code, $this->msg, $this->data);
	}

	protected function register2($user)
	{
		$userInfo = $this->getUserInfo();
		if (empty($userInfo)){
			$token = $this->getToken();
			$userInfo = $this->db->where('openid',$token['openid'])->find();
			if ($userInfo) {
				$data['openid'] = $token['openid'];
				$data['update_time'] = date('Y-m-d h:i:s', time());

				$data['company_type'] = $user['CompanyType'];
				$data['company_name'] = $user['CompanyName'];
				$data['company_userid'] = $user['CompanyUserId'];
				$data['organization_number'] = $user['OrganizationNumber'];
				$data['company_regnumber'] = $user['CompanyRegNumber'];

				$this->db->update($data);
				$userInfo = $this->db->where('openid',$token['openid'])->find();
				$this->setUserInfo($userInfo);
        $res = $userInfo;
       } else {

				$data['openid'] = $token['openid'];
				$data['nickname'] = $token['nickname'];
				$data['headimgurl'] = $token['headimgurl'];
				$data['sex'] = $token['sex'];
				$data['create_time'] = date('Y-m-d h:i:s', time());

				$data['company_type'] = $user['CompanyType'];
				$data['company_name'] = $user['CompanyName'];
				$data['company_userid'] = $user['CompanyUserId'];
				$data['organization_number'] = $user['OrganizationNumber'];
				$data['company_regnumber'] = $user['CompanyRegNumber'];

				$this->db->insert($data);
				$userInfo = $this->db->where('openid',$token['openid'])->find();
				$this->setUserInfo($userInfo);
				$res = $userInfo;
       }
    } else {
			$res = $userInfo;
			return $res;
		}

		return $userInfo;
	}

}