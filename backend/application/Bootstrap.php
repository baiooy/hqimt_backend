<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /*
     * 开启session
     */
    protected function _initSession(){
    	Zend_Session::start();
    }
    
    /*
     * 获取是国内版还是海外版
     */
    protected function _initCnOrEn(){
    	$res	= $this->getOption('resources');
    	$dbname	= $res['db']['params']['dbname'];
    	if($dbname == 'yiyou'){
    		Zend_Registry::set('version', '国内版');
    	}else{
    		Zend_Registry::set('version', '海外版');
    	}
    }

}

