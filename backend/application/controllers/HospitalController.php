<?php

class HospitalController extends Zend_Controller_Action{

    public function init(){
//     	$this->getResponse()->setHeader('Content-Type', 'application/json');
//         $this->_helper->viewRenderer->setNoRender(true);
//         $this->_helper->layout()->disableLayout();       
    }

    public function indexAction(){
    	
    }
    //根据日期查看医院注册详情
    public function detailAction(){
    	$page = $this->_getParam('page',1);
    	$date = $this->_getParam('date',NULL);
    	$data = Application_Model_M_Hospital::fetchByDate($date,$page,30);
    	$this->view->res  = $data;
    }
    
    public function viewAction(){
    	$id = $this->_getParam('id');
    	$hospital = Application_Model_M_Hospital::find($id);
    
    	if($hospital){
    		$this->view->hospital = $hospital;
    	}else{
    		$this->redirect('/error');
    	}
    }
    
    public function updateAction(){
    	$id  = $this->_getParam('id');
    	$hospital = Application_Model_M_Hospital::find($id);
    	if($hospital){
    		$this->view->hospital = $hospital;
    	}else{
    		$this->redirect('error');
    	}
    }
    
    public function addAction(){
    	;
    }
    
    public function deleteAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    
    	$id = $this->_getParam('id');
    	try {
    		Yy_Utils::RDelByHospitalID($id);
    		$out['errno'] = "0";
    	}catch(Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	}
    	Yy_Utils::jsonOut($out);
    }   
    public function asyncajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	
    	$params = $this->_getAllParams();
    	$hospital	= new Application_Model_O_Hospital();
    	$validate = new Yy_Validate_Value();
    	if($validate->isValid($params['id'])){
    		$hospital->setId($params['id']);
    	}else{
    		$hospital->setCtime(date('Y-m-d H:i:s'));
    	}
    	if($validate->isValid($params['name'])){
    		$hospital->setName($params['name']);
    	}
    	if($validate->isValid($params['email'])){
    		$hospital->setEmail($params['email']);
    	}
    	if($validate->isValid($params['departments'])){
    		$hospital->setDepartments($params['departments']);
    	}
    	if($validate->isValid($params['passwd'])){
    		$hospital->setPasswd(md5($params['passwd']));
    	}
    	if($validate->isValid($params['type'])){
    		$hospital->setType($params['type']);
    	}
    	if($validate->isValid($params['certified'])){
    		$hospital->setCertified($params['certified']);
    	}
    	if($validate->isValid($params['city'])){
    		$hospital->setCity($params['city']);
    	}
    	if($validate->isValid($params['label'])){
    		$hospital->setLabel($params['label']);
    	}
    	if($validate->isValid($params['country'])){
    		$hospital->setCountry($params['country']);
    	}
    	if($validate->isValid($params['point'])){
    		$hospital->setPoint($params['point']);
    	}
    	if($validate->isValid($params['area'])){
    		$hospital->setArea($params['area']);
    	}
    	if($validate->isValid($params['introduction'])){
    		$hospital->setIntroduction($params['introduction']);
    	}
    	if($validate->isValid($params['longitude'])){
    		$hospital->setLongitude($params['longitude']);
    	}
    	if($validate->isValid($params['latitude'])){
    		$hospital->setLatitude($params['latitude']);
    	}
    	if($validate->isValid($params['status'])){
    		$hospital->setStatus($params['status']);
    	}
    	
    	try{
    		$hospital->save();
    		$id = $hospital->getId();
    		//保存医院头像
    		$adapter = new Zend_File_Transfer_Adapter_Http();
    		$wrdir = Yy_Utils::getWriteDir();
    		$adapter->setDestination($wrdir);
    		if (!$adapter->receive()) {
    			$messages = $adapter->getMessages();
    			//echo implode("\n", $messages);
    		}
    		$filename = $adapter->getFileName();
    		if(is_string($filename)){
    			$handle = fopen($filename, 'rb');
    			$avatar = addslashes(fread($handle, filesize($filename)));
    			fclose($handle);
    			Application_Model_M_Hospital::updateAvatar($id,$avatar);
    		}
    		
    		$url = '/hospital/view?id='.$id.'&from=update';
    		$this->redirect($url);
    	}catch (Zend_Db_Exception $e){
    		//$this->redirect('/error');
    		$this->redirect('/error?message='.$e->getMessage());
    	}
    	
    }
    
    public function auditAction(){
    	$page = $this->_getParam('page',1);
    	$data = Application_Model_M_Hospital::fetchByStatus(0,$page,30);
    	$this->view->res = $data;
    	$this->render('detail');
    }
    
    public function imageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	 
    	$id = $this->_getParam('id');
    	$avatar = Application_Model_M_Hospital::getAvatar($id);
    	echo $avatar;
    }
    
    public function searchAction(){
    	$email = $this->_getParam('email',null);
    	$name = $this->_getParam('name',null);
    	if($email){//根据邮箱查找
    		$hospitals = Application_Model_M_Hospital::fetchByEmailLike($email);
    	}elseif($name){
    		$hospitals = Application_Model_M_Hospital::fetchByNameLike($name);
    	}else{
    		$hospitals = array();
    	}
    	$this->view->hospitals = $hospitals;
    }
    



}

