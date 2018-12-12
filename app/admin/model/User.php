<?php
namespace app\common\model;
use think\Db;

class AuthUser extends Base
{

    // 增加输出字段
    protected function getStatusTextAttr($value,$data)
    {
        $status = [0=>'无效',1=>'有效'];
        return $status[$data['status']];
    }
    // 分页
    public function getList($data)
    {
        $map = [];
        if (isset($data['status'])) {
            $map['a.status'] = $data['status'];
        }
        return Db::name('auth_user')
        			->alias('a')
        			->field('a.*,b.name as group_name,b.title as group_title,b.status as group_status')
        			->join('auth_group b','a.group_id = b.id','LEFT')
        			->where($map)
        			->paginate(10);
    }
    // 数据量
    public function getTotal($data)
    {
        $map = [];
        if (isset($data['status'])) {
            $map['status'] = $data['status'];
        }
    	return self::where($map)->count();
    }
}