<?php

class NuserController extends Zend_Controller_Action{

    public function init(){
//     	$this->getResponse()->setHeader('Content-Type', 'application/json');
//         $this->_helper->viewRenderer->setNoRender(true);
//         $this->_helper->layout()->disableLayout();       
    }

    public function indexAction(){
    	
    }
    
    public function searchAction(){
    	$email = $this->_getParam('email',null);
    	$mobile = $this->_getParam('mobile',null);
    	if($email){//根据邮箱查找
    		$nusers = Application_Model_M_Nuser::fetchByEmailLike($email);
    	}elseif($mobile){
    		$nusers = Application_Model_M_Nuser::fetchByMobileLike($mobile);
    	}else{
    		$nusers = array();
    	}
    	$this->view->nusers = $nusers;
    	
    }
    
    public function viewAction(){
    	$id = $this->_getParam('id');
    	$nuser = Application_Model_M_Nuser::find($id);
    	
    	if($nuser){
    		$this->view->nuser = $nuser;
    	}else{
    		$this->redirect('/error');
    	}
    }
    
    public function updateAction(){
    	$id  = $this->_getParam('id');
    	$nuser = Application_Model_M_Nuser::find($id);
    	if($nuser){
    		$this->view->nuser = $nuser;
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
    		Application_Model_M_Nuser::delById($id);
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

    	//$id = $params['id'];
    	//$nuser = Application_Model_M_Nuser::find($id);
    	$nuser = new Application_Model_O_Nuser();
    	$validate = new Yy_Validate_Value();
    	
    	if($validate->isValid($params['id'])){
    		$nuser->setId($params['id']);
    	}else{
    		$nuser->setCtime(date('Y-m-d H:i:s'));
    	}
    	if($validate->isValid($params['mobile'])){
    		$nuser->setMobile($params['mobile']);
    	}
    	if($validate->isValid($params['email'])){
    		$nuser->setEmail($params['email']);
    	}
    	if($validate->isValid($params['phone'])){
    		$nuser->setPhone($params['phone']);
    	}
    	if($validate->isValid($params['passwd'])){
    		$nuser->setPasswd(md5($params['passwd']));
    	}
    	if($validate->isValid($params['name'])){
    		$nuser->setName($params['name']);
    	}
    	if($validate->isValid($params['sex'])){
    		$nuser->setSex($params['sex']);
    	}
    	if($validate->isValid($params['job'])){
    		$nuser->setJob($params['job']); 		
    	}
    	if($validate->isValid($params['postcode'])){
    		$nuser->setPostcode($params['postcode']);
    	}
    	if($validate->isValid($params['idcard'])){
    		$nuser->setIdcard($params['idcard']);
    	}
    	if($validate->isValid($params['point'])){
    		$nuser->setPoint($params['point']);
    	}
    	if($validate->isValid($params['country'])){
    		$nuser->setCountry($params['country']);
    	}
    	if($validate->isValid($params['address'])){
    		$nuser->setAddress($params['address']);
    	}
    	if($validate->isValid($params['birthday'])){
    		$nuser->setBirthday($params['birthday']);
    	}
    	if($validate->isValid($params['status'])){
    		$nuser->setStatus($params['status']);
    	}
    	try{
    		$nuser->save();
    		$id = $nuser->getId();
    		//保存用户头像
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
	    		Application_Model_M_Nuser::updateAvatar($id,$avatar);
    		}
    		
    		$url = '/nuser/view?id='.$id.'&from=update';
    		$this->redirect($url);
    	}catch (Zend_Db_Exception $e){
    		//echo $e->getMessage();exit;
    		$this->redirect('/error?message='.$e->getMessage());
    		//$this->redirect('/error');
    	}
    }
    
    
    //根据日期查看用户注册详情
    public function detailAction(){
    	$page = $this->_getParam('page',1);
    	$date = $this->_getParam('date',NULL);
    	$data = Application_Model_M_Nuser::fetchByDate($date,$page,30);
    	$this->view->res = $data;
    }
    
    public function imageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
    	$id = $this->_getParam('id');
    	$avatar = Application_Model_M_Nuser::getAvatar($id);
    	echo $avatar;    	
    }



}

