<?php

class CardController extends Zend_Controller_Action{

    public function init(){
//     	$this->getResponse()->setHeader('Content-Type', 'application/json');
//         $this->_helper->viewRenderer->setNoRender(true);
//         $this->_helper->layout()->disableLayout();       
    }

    public function indexAction(){
    	
    }
    public function detailAction(){
    	$page  = $this->_getParam('page',1);
    	$data	= Application_Model_M_MemberCard::fetchAllPage($page,30);
    	$this->view->data = $data;
    	$this->view->page = $page;
    }
    
    public function viewAction(){
    	$id = $this->_getParam('id');
    	$card = Application_Model_M_MemberCard::find($id);
    	if($card){
    		$this->view->card = $card;
    	}else{
    		$this->redirect('/error');
    	}
    }
    
    public function updateAction(){
    	$id  = $this->_getParam('id');
    	$card = Application_Model_M_MemberCard::find($id);
    	if($card){
    		$this->view->card = $card;
    	}else{
    		$this->redirect('error');
    	}
    }
    
    public function addAction(){
    	
    }
    
    
    public function asyncajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	
    	$params = $this->_getAllParams();
    	//echo "<pre>";var_dump($params);exit;
    	$card = new Application_Model_O_MemberCard();
    	$validate = new Yy_Validate_Value();
    	 
    	if($validate->isValid($params['id'])){
    		$card->setId($params['id']);
    	}else{
    		$card->setCtime(date('Y-m-d H:i:s'));
    	}
    	if($validate->isValid($params['name'])){
    		$card->setName($params['name']);
    	}
    	if($validate->isValid($params['oprice'])){
    		$card->setOprice($params['oprice']);
    	}
    	if($validate->isValid($params['dprice'])){
    		$card->setDprice($params['dprice']);
    	}
    	if($validate->isValid($params['points'])){
    		$card->setPoints($params['points']);
    	}
    	if($validate->isValid($params['status'])){
    		$card->setStatus($params['status']);
    	}
    	try{
    	
    		$card->save();
    		$id = $card->getId();    	
    		$url = '/card/view?id='.$id;
    		$this->redirect($url);
    	}catch (Zend_Db_Exception $e){
    		//$this->redirect('/error');
    		$this->redirect('/error?message='.$e->getMessage());
    	}
    }
    public function deleteAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	
    	$id = $this->_getParam('id');
    	try {
    		Application_Model_M_MemberCard::delById($id);
    		$out['errno'] = "0";
    	}catch(Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	}
    	Yy_Utils::jsonOut($out);
    }
    
    public function orderdelAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$id = $this->_getParam('id');
    	try {
    		Application_Model_M_MemberCardOrder::delById($id);
    		$out['errno'] = "0";
    	}catch(Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	}
    	Yy_Utils::jsonOut($out);    	
    }
    
    
    public function orderAction(){ 
    	$page  = $this->_getParam('page',1);
    	$role  = $this->_getParam('role',0);//0所有，1普通用户，2医生用户，3医院用户
    	$data = Application_Model_M_MemberCardOrder::fetchAllPage($role,$page,30);
    	$this->view->data = $data;   
    	$this->view->role = $role; 	
    	$this->view->page = $page;
    }
    
    public function orderviewAction(){
    	$id = $this->_getParam('id');
    	$order = Application_Model_M_MemberCardOrder::find($id);
    	if($order){
    		$this->view->order = $order;
    	}else{
    		$this->redirect('/error');
    	}
    }



}

