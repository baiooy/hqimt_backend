<?php

class IndexController extends Zend_Controller_Action{

    public function init(){
//     	$this->getResponse()->setHeader('Content-Type', 'application/json');
//         $this->_helper->viewRenderer->setNoRender(true);
//         $this->_helper->layout()->disableLayout();       
    }

    public function indexAction(){
    	$backend = new Zend_Session_Namespace('backend');
		$user = $backend->user;
		$day = date('Y-m-d');
		$this->getWeek();
		$this->view->user = $user;
		$this->view->day  = $day;
		$this->view->week = $this->getWeek();
    }
    
    protected function getWeek(){
    	$eWeek = date('N');
    	$str = "";
    	switch ($eWeek){
    		case 1:
    			$str = "星期一";
    			break;
    		case 2:
    			$str = "星期二";
    			break;
    		case 3:
    			$str = "星期三";
    			break;
    		case 4:
    			$str = "星期四";
    			break;
    		case 5:
    			$str = "星期五";
    			break;
    		case 6:
    			$str = "星期六";
    			break;
    		case 7:
    			$str = "星期天";
    			break;
    	}
    	return $str;
    }



}

