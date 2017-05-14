<?php

namespace Wxweb\Controller;
use Common\Controller\HomebaseController; 
/**
 * 首页
 */
class BaseController extends HomebaseController {
	
   public function _initialize(){
         //判断用户是否已经登录
          if (!isset($_SESSION['uid'])) {
          	//直接跳转页面
             $this->redirect('Login/login'); 
          }
         
        

    }

}


