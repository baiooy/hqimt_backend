<?php

class ConsultController extends Zend_Controller_Action{

    public function init(){
//     	$this->getResponse()->setHeader('Content-Type', 'application/json');
//         $this->_helper->viewRenderer->setNoRender(true);
//         $this->_helper->layout()->disableLayout();       
    }
    
    
    public function orderAction(){
    	$page  = $this->_getParam('page',1);
    	//$data = Application_Model_M_MemberCardOrder::fetchAllPage($page,30);
    	$data = Application_Model_M_ConsultOrder::fetchAllPage();
    	$this->view->data = $data;
    	$this->view->page = $page;
    }
    
    public function orderdelAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    
    	$id = $this->_getParam('id');
    	try {
    		Application_Model_M_ConsultOrder::delById($id);
    		$out['errno'] = "0";
    	}catch(Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	}
    	Yy_Utils::jsonOut($out);
    }
    
    
    public function orderviewAction(){
    	$id = $this->_getParam('id');
    	$order = Application_Model_M_ConsultOrder::find($id);
    	if($order){
    		$this->view->order = $order;
    	}else{
    		$this->redirect('/error');
    	}
    }

    




}

