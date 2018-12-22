<?php
namespace app\api\controller;

class Index extends ApiBase
{
  public function index() {
    $apis = $this->apis;
    $html = '<ul>';
    foreach($apis as $key => $value) {
      $html = $html.'<li style="margin-bottom:20px;"><a target="_blank" href="/partyjo-web/api/'.$key.'">'.$key.'</a></li>';
    }
    echo $html.'</ul>';
  }
}
