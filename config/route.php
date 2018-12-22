<?php
use think\Route;

Route::rule('api/test','api/test/index');
Route::rule('api/index','api/index/index');

Route::rule('api/getAppUserInfo','api/login/getAppUserInfo');
Route::rule('api/getTaskKindOU_YY','api/yuyue/getTaskKindOU_YY');
Route::rule('api/getTaskList_YY','api/yuyue/getTaskList_YY');
Route::rule('api/getYuYueDateList','api/yuyue/getYuYueDateList');
Route::rule('api/getYuYueTimeList','api/yuyue/getYuYueTimeList');
Route::rule('api/getYuYueQNO','api/yuyue/getYuYueQNO');
Route::rule('api/getAppointmentList','api/yuyue/getAppointmentList');
Route::rule('api/getAppointDetail','api/yuyue/getAppointDetail');
Route::rule('api/Getwaitnumbytime','api/yuyue/Getwaitnumbytime');


Route::rule('api/getProjectByFlowSN','api/project/getProjectByFlowSN');
Route::rule('api/getProjectDetail','api/project/getProjectDetail');

Route::rule('api/getLobby','api/task/getLobby');
Route::rule('api/getTaskKindOU','api/task/getTaskKindOU');
Route::rule('api/getTaskList','api/task/getTaskList');
Route::rule('api/getTaskDetail','api/task/getTaskDetail');


Route::rule('api/upload_image','api/upload/image');

Route::rule('api/is_oauth','api/user/isOauth');
Route::rule('api/is_login','api/user/isLogin');
Route::rule('api/is_register','api/user/isRegister');
Route::rule('api/register','api/user/register');
Route::rule('api/loginOut','api/user/loginOut');

Route::rule('api/login','api/login/index');
Route::rule('api/login2','api/login/login2');

Route::rule('api/get_wxsdk','api/weixin/getWxsdk');

Route::rule('weixin/wxoauthback','api/weixin/wxoauthback');
Route::rule('weixin/clear','api/weixin/clear');


Route::rule('api/getMenuList','api/menu/getList');
Route::rule('api/getNewsList','api/news/getList');