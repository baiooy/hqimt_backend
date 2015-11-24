<?php

class StatisticsController extends Zend_Controller_Action{

    public function init(){
//     	$this->getResponse()->setHeader('Content-Type', 'application/json');
//         $this->_helper->viewRenderer->setNoRender(true);
//         $this->_helper->layout()->disableLayout();       
    }

    public function nuserAction(){
    	$page	= $this->_getParam('page',1);
    	$startTime = $this->_getParam('stime');
    	$endTime   = $this->_getParam('etime');
    	$count = Application_Model_M_Nuser::getCount();
    	if(!$startTime && !$endTime){//按照时间倒序
    		$res = Application_Model_M_Nuser::getCountByDay($page,30);
    		$this->view->count = $count;
    		$this->view->res = $res;
    		$this->render('stpl');
    	}else{
    		
    	}
    }
    
    public function doctorAction(){
    	$page	= $this->_getParam('page',1);
    	$startTime = $this->_getParam('stime');
    	$endTime   = $this->_getParam('etime');
    	$count = Application_Model_M_Doctor::getCount();
    	if(!$startTime && !$endTime){//按照时间倒序
    		$res = Application_Model_M_Doctor::getCountByDay($page,30);
    		$this->view->count = $count;
    		$this->view->res = $res;
    		$this->render('stpl');
    	}else{
    		
    	}
    }
    
    public function hospitalAction(){
    	$page	= $this->_getParam('page',1);
    	$startTime = $this->_getParam('stime');
    	$endTime   = $this->_getParam('etime');
    	$count = Application_Model_M_Hospital::getCount();
    	if(!$startTime && !$endTime){//按照时间倒序
    		$res = Application_Model_M_Hospital::getCountByDay($page,30);
    		$this->view->count = $count;
    		$this->view->res = $res;
    		$this->render('stpl');
    	}else{
    	
    	}
    }


}

