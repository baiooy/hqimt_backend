<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /*
     * 开启session
     */
    protected function _initSession(){
    	Zend_Session::start();
    }
    

}

