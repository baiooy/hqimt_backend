<?php
class Yy_Plugin extends Zend_Controller_Plugin_Abstract{
	public function preDispatch(Zend_Controller_Request_Abstract $request){
		$backend = new Zend_Session_Namespace('backend');
		if(!$backend->user && !$backend->role){
			$request->setControllerName('admin');
			$request->setActionName('login');
		}
	}
	
	
// 	public function postDispatch(Zend_Controller_Request_Abstract $request){
			
// 	}
	

}