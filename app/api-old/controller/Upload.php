<?php
namespace app\api\controller;
/**
*
*/
class Upload extends Base
{
	protected function before()
	{

		//$this->db = Db::name('user');
	}

	public function image()
  {
      //1.获取文件对象,数据
      $file = request()->file('image');
      $data = input('');
      //3.处理文件对象
      $path = ROOT_PATH . 'public' . DS . 'upload'; //文件保存的文件夹
      $info = $file->move($path); //移动文件到目录下
      if($info){
          $date = substr($info->getPath(),-8); //获取当前日期
          $filename= $info->getFilename(); //获取文件名
          $filepath= '/partyjo-web/public/upload/'.$date.'/'.$info->getFilename(); //获取文件有效访问地址
          $size= $info->getSize(); //获取文件大小
          $filetype= $info->getExtension(); //获取文件类型
          //4.数据处理
          $data['file_name'] = $filename;
          $data['file_path'] = $filepath;
          $data['file_size'] = $size;
          $data['fill_type'] = $filetype;

          $this->res = $data;
          $this->code = 1;
          $this->msg = '上传成功';
      }else{
          //上传失败获取错误信息
          $msg = $file->getError();
          $this->code = 0;
          $this->msg = $msg;
      }

      return $this->ajaxReturn($this->code, $this->msg, $this->res);
  }

}