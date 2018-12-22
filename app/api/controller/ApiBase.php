<?php
namespace app\api\controller;
use think\Controller;

class ApiBase extends Controller
{
    protected $paras; // 请求api的参数
    protected $code; // 返回码
    protected $msg; // 返回信息
    protected $data; // 返回数据

    protected $apis;
    protected $apiUrl;
    protected $userInfo;

    protected $servicecode;
    protected $servicepwd;

    /**
     * @cc 验证操作权限
     * @return [type] [description]
     */
    protected function _initialize()
    {
        $this->code = 1;
        $this->msg = '';
        $this->data = null;

        $this->userInfo = $this->getUserInfo();

        // $this->paras['ValidateData'] = '';
        $this->paras['params'] = [
            'centerguid' => '6bef18db-f0b8-49fd-9d39-e406ad6d5bd5'
        ];
        $this->paras['token'] = 'Epoint_WebSerivce_**##0601';

        $this->apiUrl = 'https://yc.huzhou.gov.cn:8088/wsdt/rest/hzqueueAppointment';
        $this->apiList();

        $this->before();
    }

    /**
     * 继承者们的前置方法
     * @return [type] [description]
     */
    protected function before()
    {

    }

    protected function handle($res) {
        $res = json_decode($res,true);
        // var_dump($res);
        $r = [];
        $msg = '请求成功';
        if ($res['status']['code'] == 200 && $res['custom']['code'] == 1) {
            $r['code'] = 1;
            $r['data'] = $res['custom'];
        } else {
            $r['code'] = 101;
            $res['data'] = null;
            $msg = '发生异常';
        }
        $r['msg'] = empty($res['custom']['text']) ? empty($res['status']['text']) ? $msg : $res['status']['text'] : $res['custom']['text'];
        return $r;
    }

    protected function apiList()
    {
        // 办事指南

        /**
         * 大厅列表
         * centerguid: 001008005004026
         */
        $this->apis['GetLobby'] = $this->apiUrl.'/getHallList';
        /**
         * 部门列表
         * "hallguid": 大厅id
         * shownum: 10
         */
        $this->apis['GetTaskKindOU'] = $this->apiUrl.'/getHallThemes';
        /**
         * 事项列表
         * "TaskName": "事项名称",  //搜索不传空，默认传控
         * "themeguid": "部门guid",
         * "shownum": 10
         */
        $this->apis['GetTaskList'] = $this->apiUrl.'/getChildThemes';
        /**
         * 获取浙报APP用户
         * nxwxticket: 
         */
        $this->apis['getAppUserinfo'] = $this->apiUrl.'/getUserinfo';
        /**
         * 事项详情
         * "TaskGuid": "事项guid"
         */
        $this->apis['GetTaskDetail'] = $this->apiUrl.'/AuditTask/GetTaskDetail';

        // 办事预约

        /**
         * 选择部门
         * "LobbyType": "大厅类型（传空返回所有）"
         */
        //$this->apis['GetTaskKindOU_YY'] = $this->apiUrl.'/TaskKind/GetTaskKindOU_YY';

        /**
         * 选择事项
         * "LobbyType": "A",   //大厅类别
         * "OUGuid": "部门guid",
         * "CurrentPageIndex": "1",
         * "PageSize": "10"
         */
        //$this->apis['GetTaskList_YY'] = $this->apiUrl.'/Queue/GetTaskList';

        /**
         * 获取预约日期
         * "centerguid"
         * showdays
         */
        $this->apis['GetYuYueDateList'] = $this->apiUrl.'/getAppointDate';

        /**
          * 获取预约时间段
          * accountguid
          * centerguid
          * "taskguid":"6548f82c-f302-4d77-abbb-51dfea5c232c",
          * "appointdate":"2016-04-22"
          */
        $this->apis['GetYuYueTimeList'] = $this->apiUrl.'/getAppointTime';

        /**
         * 获取各时段预约人数
         * centerguid
         * taskguid
         */
        $this->apis['getWaitNumbyTime'] = $this->apiUrl.'/getWaitNumbyTime';

         /**
         * 取消预约
         * appointguid
         */
        $this->apis['deleteAppoint'] = $this->apiUrl.'/deleteAppoint';

        /**
          * 提交预约
          * "TaskGuid":"6548f82c-f302-4d77-abbb-51dfea5c232c",//事项guid
          * "UserGuid":"用户guid",     //可以传空
          * "UserName":"预约人",
          * "IdentityCardID":"身份证",
          * "Mobile":"手机",
          * "YuYueTimeStart":"09:00",//预约开始时间
          * "YuYueTimeEnd":"10:00",//预约结束时间
          * "YuYueDate":"2016-04-22"//预约时间
          */
        $this->apis['GetYuYueQNO'] = $this->apiUrl.'/getAppointQno';

        /**
         * 预约列表
         * accountguid
         * currentpage: 1
         * pagesize: 10
         * "type": 1 今日 2 历史
         * "CurrentPageIndex":"1",
         * "PageSize":"10"
         */
        $this->apis['GetAppointmentList'] = $this->apiUrl.'/getAppointList';

        /**
         * 预约详情
         * appointguid
         */
        $this->apis['getAppointDetail'] = $this->apiUrl.'/getAppointDetail';
        /**
         * 办事查询编号
         * "FlowSN": "办件流水号",
         */
        $this->apis['GetProjectByFlowSN'] = $this->apiUrl.'/AuditProject/GetProjectByFlowSN';

        /**
         *办事查询详情
         *"ProjectGuid": "办件guid",  //上一个接口的返回
         */
        $this->apis['GetProjectDetail'] = $this->apiUrl.'/AuditProject/getProjectDetail';
    }

    protected function postUrl($url, $data)
    {
        // var_dump(json_encode($data));
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
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
        $tmpInfo = curl_exec($curl); // 执行操作
        if(curl_errno($curl)) {
           $tmpInfo = 'Errno'.curl_error($curl);
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }

    /**
     * api返回数据再处理
     * @param  [type] $res [description]
     * @return [type]      [description]
     */
    protected function dataFiltering($res)
    {
        $data = json_decode($res,true);
        if (isset($data['ReturnInfo']) && $data['ReturnInfo']['Code'] != 1) {
            $this->code = 101;
            $this->msg = $data['ReturnInfo']['Description'];
        } else if (isset($data['BusinessInfo']) && $data['BusinessInfo']['Code'] != 1) {
            $this->code = 102;
            $this->msg = $data['BusinessInfo']['Description'];
        } else {
            $this->code = 1;
            $this->data = $data['UserArea'];
        }
    }

    /**
     * ajax返回数据
     * @param  integer $code  [description]
     * @param  string  $msg   [description]
     * @param  [type]  $data  [description]
     * @param  [type]  $total [description]
     * @return [type]         [description]
     */
    protected function ajaxReturn($code = 1, $msg = '', $data = null, $total = null)
    {
        $res = [];

        $res['ret'] = $code;

        if ($msg == '') {
            $res['msg'] = '操作成功';
        } else {
            $res['msg'] = $msg;
        }

        if(!is_null($data)) {
            $res['data'] = $data;
        }

        if(!is_null($total)) {
            $res['total'] = $total;
        }

        return $res;
    }

    //获取登陆信息
    protected function getUserInfo()
    {
        return session('ZM_USER_INFO');
    }
    //存储登陆信息
    protected function setUserInfo($info)
    {
        return session('ZM_USER_INFO',$info);
    }
    //获取授权信息
    protected function getToken()
    {
        return [
                'openid'=>'o9-y-0zpSkPbcDqRpUel0kK50Adc',
                'nickname'=>'阿敏',
                'headimgurl'=>'http://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eo3yW0arVaSoatJVz8AHdyW59tia3HJHk2s5sP9v6o3JpBqN1Hm8jSgNDxPwgxhwV42USic22PZPnDw/0',
                'sex'=>1
            ];
        return session('ZM_WX_OAUTH_INFO');
    }

}