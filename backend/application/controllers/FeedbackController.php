<?php

class FeedbackController extends Zend_Controller_Action{

    public function init(){
    	     
    }

    public function detailAction(){
    	$page  = $this->_getParam('page',1);
    	$data	= Application_Model_M_Feedback::fetchAllPage($page,30);
    	$this->view->data = $data;
    	$this->view->page = $page;
    }
    
    public function viewAction(){
    	$id = $this->_getParam('id');
    	$feedback = Application_Model_M_Feedback::find($id);
    	if($feedback){
    		$this->view->feedback = $feedback;
    	}else{
    		$this->redirect('/error');
    	}    	
    }
    
    public function deleteAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$id = $this->_getParam('id');
    	try {
    		Application_Model_M_Feedback::delById($id);
    		$out['errno'] = "0";
    	}catch(Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	}
    	Yy_Utils::jsonOut($out);
    }



}

