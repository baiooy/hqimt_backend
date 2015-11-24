<?php

class TravelController extends Zend_Controller_Action{

    public function init(){
//     	$this->getResponse()->setHeader('Content-Type', 'application/json');
//         $this->_helper->viewRenderer->setNoRender(true);
//         $this->_helper->layout()->disableLayout();       
    }

    public function indexAction(){
    	
    }
    public function detailAction(){
    	$page  = $this->_getParam('page',1); //1体检与疗养，2看病，3美容与抗衰老
    	$type = $this->_getParam('type',1);
    	$data	= Application_Model_M_Travel::fetchByType($type,$page,30);
    	$this->view->data = $data;
    	$this->view->type = $type;
    	$this->view->page = $page;
    	
    }
    
    public function viewAction(){
    	$id = $this->_getParam('id');
    	$travel = Application_Model_M_Travel::find($id);
    	if($travel){
    		$this->view->travel = $travel;
    	}else{
    		$this->redirect('/error');
    	}
    }
    
    public function updateAction(){
    	$id  = $this->_getParam('id');
    	$travel = Application_Model_M_Travel::find($id);
    	if($travel){
    		$this->view->travel = $travel;
    	}else{
    		$this->redirect('error');
    	}
    }
/*    
    public function updateajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$params = $this->_getAllParams();
    	//var_dump($params);exit;
    	$id = $params['id'];
    	$travel = Application_Model_M_Travel::find($id);
    	$validate = new Yy_Validate_Value();
    	if($validate->isValid($params['location_type'])){
    		$travel->setLocation_type($params['location_type']);
    	}
    	if($validate->isValid($params['adult_oprice'])){
    		$travel->setAdult_oprice($params['adult_oprice']);
    	}
    	if($validate->isValid($params['adult_dprice'])){
    		$travel->setAdult_dprice($params['adult_dprice']);
    	}
    	if($validate->isValid($params['child_oprice'])){
    		$travel->setChild_oprice($params['child_oprice']);
    	}
    	if($validate->isValid($params['child_dprice'])){
    		$travel->setChild_dprice($params['child_dprice']);
    	}
    	if($validate->isValid($params['area'])){
    		$travel->setArea($params['area']);
    	}
    	if($validate->isValid($params['sales'])){
    		$travel->setSales($params['sales']);
    	}
    	if($validate->isValid($params['title'])){
    		$travel->setTitle($params['title']);
    	}
    	if($validate->isValid($params['subtitle'])){
    		$travel->setSubtitle($params['subtitle']);
    	}
    	if($validate->isValid($params['status'])){
    		$travel->setStatus($params['status']);
    	}
    	
    	try{
    		$travel->save();
    		
    		//保存行程图片
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
    			Application_Model_M_Travel::updateImage($id,$img);
    		}
    		
    		
    		$url = '/travel/view?id='.$id.'&from=update';
    		$this->redirect($url);
    	}catch (Zend_Db_Exception $e){
    		//$this->redirect('/error');
    		$this->redirect('/error?message='.$e->getMessage());
    	}
    }
*/    
    public function addAction(){
    	$type = $this->_getParam('type',1);
    	$this->view->type = $type;
    }
    
    public function asyncajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	
    	$params = $this->_getAllParams();
    	
    	//var_dump($params);exit;
    	//     	unset($params['controller']);
    	//     	unset($params['action']);
    	//     	unset($params['module']);
    	$travel = new Application_Model_O_Travel();
    	$validate = new Yy_Validate_Value();
    	
    	if($validate->isValid($params['id'])){
    		$travel->setId($params['id']);
    	}else{
    		$travel->setCtime(date('Y-m-d H:i:s'));
    	}
    	
    	if($validate->isValid($params['type'])){
    		$travel->setType($params['type']);
    	}
    	if($validate->isValid($params['location_type'])){
    		$travel->setLocation_type($params['location_type']);
    	}
    	if($validate->isValid($params['adult_oprice'])){
    		$travel->setAdult_oprice($params['adult_oprice']);
    	}
    	if($validate->isValid($params['adult_dprice'])){
    		$travel->setAdult_dprice($params['adult_dprice']);
    	}
    	if($validate->isValid($params['child_oprice'])){
    		$travel->setChild_oprice($params['child_oprice']);
    	}
    	
    	if($validate->isValid($params['child_dprice'])){
    		$travel->setChild_dprice($params['child_dprice']);
    	}
    	if($validate->isValid($params['area'])){
    		$travel->setArea($params['area']);
    	}
    	
    	if($validate->isValid($params['sales'])){
    		$travel->setSales($params['sales']);
    	}
    	
    	if($validate->isValid($params['title'])){
    		$travel->setTitle($params['title']);
    	}
    	if($validate->isValid($params['subtitle'])){
    		$travel->setSubtitle($params['subtitle']);
    	}
    	if($validate->isValid($params['status'])){
    		$travel->setStatus($params['status']);
    	}
    	
    	try{
    		
    		$travel->save();
    		$id = $travel->getId();
    		
    		//保存行程图片
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
    			Application_Model_M_Travel::updateImage($id,$img);
    		}
    		
    		$url = '/travel/view?id='.$id.'&from=add';
    		$this->redirect($url);
    	}catch (Zend_Db_Exception $e){
    		$this->redirect('/error?message='.$e->getMessage());
    	}
    	
    }
    
    public function orderAction(){
    	$page  = $this->_getParam('page',1);
    	$type = $this->_getParam('type',1);
    	$orders = Application_Model_M_TravelOrder::fetchByType($type,$page,30);
    	$this->view->type = $type;
    	$this->view->orders = $orders;
    	
    }
    public function orderviewAction(){
    	$id = $this->_getParam('id');
    	$order = Application_Model_M_TravelOrder::find($id);
    	if($order){
    		$this->view->order = $order;
    	}else{
    		$this->redirect('/error');
    	}
    }
    
    public function orderdelAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    
    	$id = $this->_getParam('id');
    	try {
    		Application_Model_M_TravelOrder::delById($id);
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
    	$img = Application_Model_M_Travel::getImage($id);
    	echo $img;
    }
    
    public function addiimageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	 
    	$id = $this->_getParam('id');
    	$img = Application_Model_M_TravelAdditional::getImage($id);
    	echo $img;
    }
    
    public function addidetailAction(){
    	$tid = $this->_getParam('id',NULL);
    	$results = Application_Model_M_TravelAdditional::fetchByTravelID($tid);
    	$res1 = array();
    	$res2 = array();
    	$res3 = array();
    	$res4 = array();
    	$res5 = array();
    	if(count($results)>0){
    		foreach($results as $result){
    			$type = $result->getType();
    			switch ($type){
    				case 1:
    					array_push($res1, $result);
    					break;
    				case 2:
    					array_push($res2, $result);
    					break;
    				case 3:
    					array_push($res3, $result);
    					break;
    				case 4:
    					array_push($res4, $result);
    					break;
    				case 5:
    					array_push($res5, $result);
    					break;
    				default:
    					break;
    			}
    		}
    	}
    	$this->view->res1 = $res1;
    	$this->view->res2 = $res2;
    	$this->view->res3 = $res3;
    	$this->view->res4 = $res4;
    	$this->view->res5 = $res5;
    	$this->view->tid  = $tid;
    }
    
    public function addiviewAction(){
    	$id = $this->_getParam('id');
    	$addi = Application_Model_M_TravelAdditional::find($id);
    	if($addi){
    		$this->view->addi = $addi;
    	}else{
    		$this->redirect('/error');
    	}
    }
    
    public function addiupdateAction(){
    	$id  = $this->_getParam('id');
    	$addi = Application_Model_M_TravelAdditional::find($id);
    	if($addi){
    		$this->view->addi = $addi;
    	}else{
    		$this->redirect('error');
    	}
    	
    }

/*
    public function addiupdateajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	
    	$params = $this->_getAllParams();
    	//var_dump($params);exit;
    	$id = $params['id'];
    	$addi = Application_Model_M_TravelAdditional::find($id);
    	$validate = new Yy_Validate_Value();
    	if($validate->isValid($params['title'])){
    		$addi->setTitle($params['title']);
    	}
    	if($validate->isValid($params['content'])){
    		$addi->setContent($params['content']);
    	}
    	if($validate->isValid($params['sort'])){
    		$addi->setSort($params['sort']);
    	}
    	if($validate->isValid($params['status'])){
    		$addi->setStatus($params['status']);
    	}
    	
    	try{
    		$addi->save();
    	
    		//保存附加行程图片
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
    			Application_Model_M_TravelAdditional::updateImage($id,$img);
    		}
    	
    	
    		$url = '/travel/addiview?id='.$id.'&from=update';
    		$this->redirect($url);
    	}catch (Zend_Db_Exception $e){
    		//$this->redirect('/error');
    		$this->redirect('/error?message='.$e->getMessage());
    	}
    }
*/    
    public function addiaddAction(){
    	$tid = $this->_getParam('id');
    	$this->view->tid = $tid;   	
    }
    
    public function addiasyncajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$params = $this->_getAllParams();
    	$hmsg = $this->_getParam('hmsg'); 
//    	echo "<pre>";var_dump($params);exit;
    	//     	unset($params['controller']);
    	//     	unset($params['action']);
    	//     	unset($params['module']);
    	$addi = new Application_Model_O_TravelAdditional();
    	$validate = new Yy_Validate_Value();
    	
    	if($validate->isValid($params['id'])){
    		$addi->setId($params['id']);
    	}else{
    		$addi->setCtime(date('Y-m-d H:i:s'));
    	}
    	if($validate->isValid($params['tid'])){
    		$addi->setTravel_id($params['tid']);
    	}
    	if($validate->isValid($params['title'])){
    		$addi->setTitle($params['title']);
    	}
    	if($validate->isValid($params['content'])){
    		$addi->setContent($params['content']);
    	}
    	if($validate->isValid($params['sort'])){
    		$addi->setSort($params['sort']);
    	}
    	if($validate->isValid($params['type'])){
    		$addi->setType($params['type']);
    	}
    	if($validate->isValid($params['status'])){
    		$addi->setStatus($params['status']);
    	}
    	
    	
    	try{
    		
    		$addi->save();
    		$id = $addi->getId();
    	
    		//保存行程附件信息图片
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
    			Application_Model_M_TravelAdditional::updateImage($id, $img);
    		}
    	
    		$url = '/travel/addiview?id='.$id.'&from=add&tid='.$params['tid'].'&hmsg='.$hmsg;
    		$this->redirect($url);
    	}catch (Zend_Db_Exception $e){
    		$this->redirect('/error?message='.$e->getMessage());
    	}
    }
    
    
    public function deleteAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$id = $this->_getParam('id');
    	try {
			Yy_Utils::RDelByTravelID($id);
    		$out['errno'] = "0";
    	}catch(Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	}
    	Yy_Utils::jsonOut($out);
    }
    public function addidelAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	
    	$id = $this->_getParam('id');
    	try {
    		Application_Model_M_TravelAdditional::delById($id);
    		$out['errno'] = "0";
    	}catch(Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	}
    	Yy_Utils::jsonOut($out);    	
    }
    
    public function importAction(){
    	$type = $this->_getParam('type',1);
    	$this->view->type = $type;  
    	
    	
    	
    	$adapter = new Zend_File_Transfer_Adapter_Http();
    	$wrdir = Yy_Utils::getWriteDir();
    	$adapter->setDestination($wrdir);
    	if (!$adapter->receive()) {
    		$messages = $adapter->getMessages();
    		//echo implode("\n", $messages);
    	}
    	//echo APPLICATION_PATH;exit;
    	$filename = $adapter->getFileName();
    	if(is_string($filename)){//上传文件后的处理
			require_once APPLICATION_PATH.'/../library/Yy/Excel/PHPExcel/IOFactory.php';
			
			if(PHP_OS == 'WINNT'){
				$filename = iconv('UTF-8', 'gb2312', $filename);
			}
			
			$inputFileType = PHPExcel_IOFactory::identify($filename);
			if(stristr($inputFileType,'excel')||stristr($inputFileType,'csv')){
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($filename);
					
				$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				array_shift($sheetData);
				if(count($sheetData)>0){
					$travels = array();
					foreach ($sheetData as $record){
						$travel = new Application_Model_O_Travel();
						$travel
								->setType($type)
						;
						if($record['A'] == '国内'){
							$ltype = 1;
						}elseif ($record['A'] == '国外'){
							$ltype = 2;
						}else{
							continue;
						}
						$travel->setLocation_type($ltype);
						$travel
								->setAdult_oprice($record['B'])
								->setAdult_dprice($record['C'])
								->setChild_oprice($record['D'])
								->setChild_dprice($record['E'])
								->setArea($record['F'])
								->setTitle($record['G'])
								->setSubtitle($record['H'])
								;
						if($record['I'] == '正常'){
							$status = 1;
						}elseif ($record['I'] == '禁用'){
							$status = 0;
						}else{
							continue;
						}
						$travel->setStatus($status);
						try {
							$travel->setCtime(date('Y-m-d H:i:s'));
							$travel->save();
							array_push($travels, $travel);
							$this->view->travels = $travels;
						}catch (Zend_Db_Exception $e){
							
						}
					}
				}
			}else{
				echo "<script type='text/javascript'>alert('请上传正确的文件类型')</script>";
			}

	
    	}
    	
    }



}

