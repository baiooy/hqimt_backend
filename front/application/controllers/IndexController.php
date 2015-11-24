<?php

class IndexController extends Zend_Controller_Action{

    public function init(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();       
    }

    public function indexAction(){
        $str = 'welcom to hqimt';
        $out['errno'] = '0';
        $out['wel'] = $str;
        Yy_Utils::jsonOut($out);
    }



}

