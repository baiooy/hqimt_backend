<?php
/*
 * 获取需要展示的广告
 */
class BannerController extends Zend_Controller_Action
{

    public function init()
    {
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->_helper->viewRenderer->setNoRender(true); 
        $this->_helper->layout()->disableLayout();
    }

    public function indexAction(){
        $data  = Application_Model_M_Banner::fetchByStatus(1);
        if (count($data)>0){
        	$out['errno']  = '0';
        	$records   = array();
        	foreach ($data as $k=>$Application_Model_O_Banner){
        		$record   = array(
        			'img' => '/banner/image?id='.$Application_Model_O_Banner->getId(),
        		    'title'  => $Application_Model_O_Banner->getTitle(),
        		    'content' => $Application_Model_O_Banner->getContent(),
        		    'link'    => $Application_Model_O_Banner->getLink(),
        		);
        		$records[]    = $record;
        	}
        	$out['banner']    = $records;
        
        }else{
        	$out['errno']  = '1';
        	
        }
        $out['msg']    = Yy_ErrMsg_Banner::getMsg('index', $out['errno']);
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

