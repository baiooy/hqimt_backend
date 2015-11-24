<?php

class ArticleController extends Zend_Controller_Action{

    public function init(){
    	   
    }

    public function indexAction(){
    	
    }
    
    public function detailAction(){
    	$type  = $this->_getParam('type',1);
    	$page  = $this->_getParam('page',1);
    	$data  = Application_Model_M_Article::fetchAllPage($type,$page,30);
    	//var_dump($data);exit;
    	$this->view->data = $data;
    	$this->view->page = $page;
    	$this->view->type = $type;
    }
    
    public function deleteAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    
    	$id = $this->_getParam('id');
    	try {
    		Application_Model_M_Article::delById($id);
    		$out['errno'] = "0";
    	}catch(Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	}
    	Yy_Utils::jsonOut($out);
    }
    
    public function viewAction(){
    	$id = $this->_getParam('id');
    	$article = Application_Model_M_Article::find($id);
    	if($article){
    		$this->view->article = $article;
    	}else{
    		$this->redirect('/error');
    	}
    }

    public function imageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    
    	$id = $this->_getParam('id');
    	$img = Application_Model_M_Article::getImage($id);
    	echo $img;
    }
    
    public function updateAction(){
        $id = $this->_getParam('id');
    	$article = Application_Model_M_Article::find($id);
    	if($article){
    		$this->view->article = $article;
    	}else{
    		$this->redirect('/error');
    	}    
    }
    public function asyncajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    
    	$params = $this->_getAllParams();
    	$article = new Application_Model_O_Article();
    	$validate = new Yy_Validate_Value();
    	 
    	if($validate->isValid($params['id'])){
    		$article->setId($params['id']);
    	}else{
    		$article->setCtime(date('Y-m-d H:i:s'));
    	}
    	if($validate->isValid($params['title'])){
    		$article->setTitle($params['title']);
    	}
    	if($validate->isValid($params['content'])){
    		$article->setContent($params['content']);
    	}
    	if($validate->isValid($params['sort'])){
    		$article->setSort($params['sort']);
    	}
    	if($validate->isValid($params['type'])){
    		$article->setType($params['type']);
    	}
    	if($validate->isValid($params['status'])){
    		$article->setStatus($params['status']);
    	}
    	
    	try{
    	
    		$article->save();
    		$id = $article->getId();
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
    			Application_Model_M_Article::updateImage($id,$img);
    		}
    	
    	
    	
    		$url = '/article/view?id='.$id;
    		$this->redirect($url);
    	}catch (Zend_Db_Exception $e){
    		//$this->redirect('/error');
    		$this->redirect('/error?message='.$e->getMessage());
    	}
    }
    public function addAction(){
    	$type = $this->_getParam('type',1);
    	$this->view->type = $type;
    }

}

