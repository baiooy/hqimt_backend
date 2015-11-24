<?php

class AdminController extends Zend_Controller_Action{
	public function init(){
		$this->_helper->layout()->disableLayout();
	}
	public function loginAction(){
		$account = $this->_getParam('account');
		$passwd  = $this->_getParam('passwd');
		if(!$account && !$passwd){
			
		}else{
			$admin = Application_Model_M_Admin::fetchByAccountAndPasswd($account,md5($passwd));
			if($admin){
				$backend = new Zend_Session_Namespace('backend');
				$backend->user = $admin->getAccount();
				$backend->role = $admin->getRole();
				$this->_redirect('/index/index');
			}
		}
		
	}
	public function logoutAction(){
 		$this->_helper->viewRenderer->setNoRender(true); 
 		Zend_Session::destroy();
 		$this->_redirect('/index/index');
	}
	public function changepasswdAction(){
		$this->getResponse()->setHeader('Content-Type', 'application/json');
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
		$account = $this->_getParam('account');
		$passwd	 = $this->_getParam('passwd');
		$status = Application_Model_M_Admin::changePasswdByAccount($account,$passwd);
		if($status){
			$out['errno'] = '0';
		}else{
			$out['errno'] = '1';
		}
		Yy_Utils::jsonOut($out);
	}
}