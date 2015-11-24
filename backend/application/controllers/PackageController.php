<?php

class PackageController extends Zend_Controller_Action{

    public function init(){
    
    }

    public function detailAction(){
    	$os = $this->_getParam('os',NULL);
    	$page = $this->_getParam('page',1);
    	$data	= Application_Model_M_PackageMgt::fetchByPlatformPage($os,$page,30);
    	$this->view->data = $data;
    	$this->view->page = $page;
    	$this->view->os	  = $os;
    	
    	
    }
    
    public function viewAction(){
    	$id = $this->_getParam('id');
    	$package = Application_Model_M_PackageMgt::find($id);
    	if($package){
    		$this->view->package = $package;
    	}else{
    		$this->redirect('/error');
    	}
    }
    
    public function updateAction(){
    	$id  = $this->_getParam('id');
    	$package = Application_Model_M_PackageMgt::find($id);
    	if($package){
    		$this->view->package = $package;
    	}else{
    		$this->redirect('/error');
    	}   	
    }
    
    public function asyncajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$params = $this->_getAllParams();
    	//echo "<pre>";var_dump($params);exit;
    	$package = new Application_Model_O_PackageMgt();
    	$validate = new Yy_Validate_Value();
    	if($validate->isValid($params['id'])){
    		$package->setId($params['id']);
    	}else{
    		$package->setCtime(date('Y-m-d H:i:s'));
    	}
    	if($validate->isValid($params['name'])){
    		$package->setName($params['name']);
    	}
    	if($validate->isValid($params['description'])){
    		$package->setDescription($params['description']);
    	}
    	if($validate->isValid($params['version'])){
    		$package->setVersion($params['version']);
    	}
    	if($validate->isValid($params['platform'])){
    		$package->setPlatform($params['platform']);
    	}
    	if($validate->isValid($params['url'])){
    		$package->setUrl($params['url']);
    	}
    	if($validate->isValid($params['status'])){
    		$package->setStatus($params['status']);
    	}
    	
    	try{
    		$package->save();
    		$id = $package->getId();   		 
    		$url = '/package/view?id='.$id;
    		$this->redirect($url);
    	}catch (Zend_Db_Exception $e){
    		$this->redirect('/error?message='.$e->getMessage());
    	}
    }
    
    public function addAction(){
    	
    }
    
    public function deleteAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$id = $this->_getParam('id');
    	try {
    		Application_Model_M_PackageMgt::delById($id);
    		$out['errno'] = "0";
    	}catch(Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	}
    	Yy_Utils::jsonOut($out);
    }



}

