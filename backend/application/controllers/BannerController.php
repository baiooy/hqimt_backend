<?php

class BannerController extends Zend_Controller_Action{

    public function init(){
//     	$this->getResponse()->setHeader('Content-Type', 'application/json');
//         $this->_helper->viewRenderer->setNoRender(true);
//         $this->_helper->layout()->disableLayout();       
    }

    public function indexAction(){
    	
    }
    
    public function detailAction(){
    	$page  = $this->_getParam('page');
    	$banners	= Application_Model_M_Banner::fetchAllPage($page,30);
    	$this->view->banners = $banners;
    }
    
    public function viewAction(){
    	$id	= $this->_getParam('id');
    	$banner = Application_Model_M_Banner::find($id);
    	if($banner){
    		$this->view->banner = $banner;
    	}else{
    		$this->redirect('/error');
    	}	
    }
    
    public function updateAction(){
    	$id = $this->_getParam('id');
    	$banner = Application_Model_M_Banner::find($id);
    	if($banner){
    		$this->view->banner = $banner;
    	}else{
    		$this->redirect('/error');
    	}
    }
/*    
    public function updateajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$params = $this->_getAllParams();
    	//     	unset($params['controller']);
    	//     	unset($params['action']);
    	//     	unset($params['module']);
    	$id = $params['id'];
    	$banner = Application_Model_M_Banner::find($id);
    	$validate = new Yy_Validate_Value();
    	if($validate->isValid($params['title'])){
    		$banner->setTitle($params['title']);
    	}
    	if($validate->isValid($params['sort'])){
    		$banner->setSort($params['sort']);
    	}
    	if($validate->isValid($params['status'])){
    		$banner->setStatus($params['status']);
    	}
    	
    	try{
    		$banner->save();
    		
    		//保存广告图片
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
    			$img = addslashes(fread($handle, filesize($filename)));
    			fclose($handle);
    			Application_Model_M_Banner::updateImage($id,$img);
    		}
    		
    		$url = '/banner/view?id='.$id.'&from=update';
    		$this->redirect($url);
    	}catch (Zend_Db_Exception $e){
    		//$this->redirect('/error');
    		$this->redirect('/error?message='.$e->getMessage());
    	}
    }
*/    
    public function addAction(){
    	;
    }
    
    public function asyncajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$params = $this->_getAllParams();
    	$banner = new Application_Model_O_Banner();
    	$validate = new Yy_Validate_Value();
    	
    	if($validate->isValid($params['id'])){
    		$banner->setId($params['id']);
    	}else{
    		$banner->setCtime(date('Y-m-d H:i:s'));
    	}
    	if($validate->isValid($params['title'])){
    		$banner->setTitle($params['title']);
    	}
    	if($validate->isValid($params['content'])){
    		$banner->setContent($params['content']);
    	}
    	if($validate->isValid($params['link'])){
    		$banner->setLink($params['link']);
    	}
    	
    	if($validate->isValid($params['sort'])){
    		$banner->setSort($params['sort']);
    	}
    	if($validate->isValid($params['status'])){
    		$banner->setStatus($params['status']);
    	}
    	try{
    		
    		$banner->save();
    		$id = $banner->getId();
    		//保存广告图片
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
    			$img = addslashes(fread($handle, filesize($filename)));
    			fclose($handle);
    			Application_Model_M_Banner::updateImage($id,$img);
    		}
    		
    		
    		
    		$url = '/banner/view?id='.$id.'&from=add';
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
    		Application_Model_M_Banner::delById($id);
    		$out['errno'] = "0";
    	}catch(Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	}
    	Yy_Utils::jsonOut($out);
    }
    
    public function imageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    
    	$id = $this->_getParam('id');
    	$img = Application_Model_M_Banner::getImage($id);
    	echo $img;
    }


}

