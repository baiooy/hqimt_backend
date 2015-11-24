<?php

class DoctorController extends Zend_Controller_Action{

    public function init(){
//     	$this->getResponse()->setHeader('Content-Type', 'application/json');
//         $this->_helper->viewRenderer->setNoRender(true);
//         $this->_helper->layout()->disableLayout();       
    }

    public function indexAction(){
    	
    }
    
    public function viewAction(){
    	$id = $this->_getParam('id');
    	$doctor = Application_Model_M_Doctor::find($id);
    	 
    	if($doctor){
    		$this->view->doctor = $doctor;
    	}else{
    		$this->redirect('/error');
    	}
    }
    
    public function auditAction(){
    	$page = $this->_getParam('page',1);
    	$data = Application_Model_M_Doctor::fetchByStatus(0);
    	$this->view->res = $data;
    	$this->render('detail');
    }
    
    public function updateAction(){
    	$id  = $this->_getParam('id');
    	$doctor = Application_Model_M_Doctor::find($id);
    	if($doctor){
    		$this->view->doctor = $doctor;
    	}else{
    		$this->redirect('error');
    	}
    }
    
    public function deleteAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    
    	$id = $this->_getParam('id');
    	try {
    		Application_Model_M_Doctor::delById($id);
    		$out['errno'] = "0";
    	}catch(Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	}
    	Yy_Utils::jsonOut($out);
    }

    public function addAction(){
    	 
    }
    
    public function updateajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$params = $this->_getAllParams();
    	//     	unset($params['controller']);
    	//     	unset($params['action']);
    	//     	unset($params['module']);
    	//$id = $params['id'];
    	$doctor = new Application_Model_O_Doctor();
    	$validate = new Yy_Validate_Value();
    	
    	if($validate->isValid($params['id'])){
    		$doctor->setId($params['id']);
    	}else{
    		$doctor->setCtime(date('Y-m-d H:i:s'));
    	}
    	if($validate->isValid($params['name'])){
    		$doctor->setName($params['name']);
    	}
    	if($validate->isValid($params['sex'])){
    		$doctor->setSex($params['sex']);
    	}
    	if($validate->isValid($params['birthday'])){
    		$doctor->setBirthday($params['birthday']);
    	}
    	if($validate->isValid($params['email'])){
    		$doctor->setEmail($params['email']);
    	}
    	if($validate->isValid($params['passwd'])){
    		$doctor->setPasswd(md5($params['passwd']));
    	}
    	if($validate->isValid($params['department'])){
    		$doctor->setDepartment($params['department']);
    	}
    	if($validate->isValid($params['point'])){
    		$doctor->setPoint($params['point']);
    	}
    	if($validate->isValid($params['city'])){
    		$doctor->setCity($params['city']);
    	}
    	if($validate->isValid($params['certified'])){
    		$doctor->setCertified($params['certified']);
    	}
    	if($validate->isValid($params['special'])){
    		$doctor->setSpecial($params['special']);
    	}
    	if($validate->isValid($params['country'])){
    		$doctor->setCountry($params['country']);
    	}
    	if($validate->isValid($params['introduction'])){
    		$doctor->setIntroduction($params['introduction']);
    	}
    	if($validate->isValid($params['hospital'])){
    		$doctor->setHospital($params['hospital']);
    	}
    	if($validate->isValid($params['area'])){
    		$doctor->setArea($params['area']);
    	}
    	if($validate->isValid($params['qualification'])){
    		$doctor->setQualification($params['qualification']);
    	}
    	if($validate->isValid($params['reservation_fee'])){
    		$doctor->setReservation_fee($params['reservation_fee']);
    	}
    	if($validate->isValid($params['reservation_number'])){
    		$doctor->setReservation_number($params['reservation_number']);
    	}
    	if($validate->isValid($params['status'])){
    		$doctor->setStatus($params['status']);
    	}
    	try{
    		$doctor->save();
    		$id = $doctor->getId();
    		//保存医生头像
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
    			Application_Model_M_Doctor::updateAvatar($id,$avatar);
    		}
    		
    		$url = '/doctor/view?id='.$id;
    		$this->redirect($url);
    	}catch (Zend_Db_Exception $e){
    		//$this->redirect('/error');
    		$this->redirect('/error?message='.$e->getMessage());
    	}
    }
    //根据日期查看医生注册详情
    public function detailAction(){
    	$page = $this->_getParam('page',1);
    	$date = $this->_getParam('date',NULL);
    	$data = Application_Model_M_Doctor::fetchByDate($date,$page,30);
    	$this->view->res = $data;
    }
    
    public function imageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	 
    	$id = $this->_getParam('id');
    	$avatar = Application_Model_M_Doctor::getAvatar($id);
    	echo $avatar;
    }
    
    public function searchAction(){
    	$email = $this->_getParam('email',null);
    	$name = $this->_getParam('name',null);
    	if($email){//根据邮箱查找
    		$doctors = Application_Model_M_Doctor::fetchByEmailLike($email);
    	}elseif($name){
    		$doctors = Application_Model_M_Doctor::fetchByNameLike($name);
    	}else{
    		$doctors = array();
    	}
    	$this->view->doctors = $doctors;   	 
    }


}

