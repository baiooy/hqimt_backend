<?php

class DestinationController extends Zend_Controller_Action{

    public function init(){
//     	$this->getResponse()->setHeader('Content-Type', 'application/json');
//         $this->_helper->viewRenderer->setNoRender(true);
//         $this->_helper->layout()->disableLayout();       
    }

    public function indexAction(){
    	
    }
    
    public function detailAction(){
    	$page  = $this->_getParam('page',1);
    	$data = Application_Model_M_Destination::fetchByType(0,$page,30);
    	$this->view->data = $data;
    	$this->view->page = $page;
    }
    
    
    public function viewAction(){
    	$id = $this->_getParam('id');
    	$dest = Application_Model_M_Destination::find($id);
    	if($dest){
    		$this->view->dest = $dest;
    	}else{
    		$this->redirect('/error');
    	}
    }
    
    public function updateAction(){
    	$id  = $this->_getParam('id');
    	$dest = Application_Model_M_Destination::find($id);
    	if($dest){
    		$this->view->dest = $dest;
    	}else{
    		$this->redirect('error');
    	}
    }
    
    public function imageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	 
    	$id = $this->_getParam('id');
    	$img = Application_Model_M_Destination::getImage($id);
    	echo $img;
    }
    
    /*
     * 增加医游目的地，提供view
     */
    public function addAction(){
    	;
    }
    
    public function asyncajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$params = $this->_getAllParams();
    	 
    	//echo "<pre>";var_dump($params);exit;
    	//     	unset($params['controller']);
    	//     	unset($params['action']);
    	//     	unset($params['module']);
    	$dest = new Application_Model_O_Destination();
    	$validate = new Yy_Validate_Value();
    	if($validate->isValid($params['id'])){
    		$dest->setId($params['id']);
    	}else{
    		$dest->setCtime(date('Y-m-d H:i:s'));
    	}
    	if($validate->isValid($params['city'])){
    		$dest->setCity($params['city']);
    	}
    	if($validate->isValid($params['type'])){
    		$dest->setType($params['type']);
    	}
    	if($validate->isValid($params['longitude'])){
    		$dest->setLongitude($params['longitude']);
    	}
    	if($validate->isValid($params['latitude'])){
    		$dest->setLatitude($params['latitude']);
    	}
    	if($validate->isValid($params['sort'])){
    		$dest->setSort($params['sort']);
    	}
    	if($validate->isValid($params['status'])){
    		$dest->setStatus($params['status']);
    	}
    	
    	try{
    		
    		$dest->save();
    		$id = $dest->getId();
    	
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
    			Application_Model_M_Destination::updateImage($id, $img);
    		}
    	
    		$url = '/destination/view?id='.$id.'&from=add';
    		$this->redirect($url);
    	}catch (Zend_Db_Exception $e){
    		$this->redirect('/error?message='.$e->getMessage());
    	}
    }
    
    public function addidetailAction(){
    	$did = $this->_getParam('id',NULL);
		$results = Application_Model_M_DestinationAdditional::fetchByDestinationID($did);
    	$res1 = array();
    	$res2 = array();
    	$res3 = array();
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
    				default:
    					break;
    			}
    		}
    	}
    	$this->view->res1 = $res1;
    	$this->view->res2 = $res2; 
    	$this->view->did  = $did; 	
    }
    
    public function addiviewAction(){
    	$id = $this->_getParam('id');
    	$addi = Application_Model_M_DestinationAdditional::find($id);
    	if($addi){
    		$this->view->addi = $addi;
    	}else{
    		$this->redirect('/error');
    	}    	
    }
    
    public function addiupdateAction(){
    	$id  = $this->_getParam('id');
    	$addi = Application_Model_M_DestinationAdditional::find($id);
    	if($addi){
    		$this->view->addi = $addi;
    	}else{
    		$this->redirect('error');
    	}    	
    }
    
    
    public function addiaddAction(){
    	$did = $this->_getParam('id');
    	$this->view->did = $did;    	
    }
    
    public function addiimageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
    	$id = $this->_getParam('id');
    	$img = Application_Model_M_DestinationAdditional::getImage($id);
    	echo $img;    	
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
    	$addi = new Application_Model_O_DestinationAdditional();
    	$validate = new Yy_Validate_Value();
    	if($validate->isValid($params['id'])){
    		$addi->setId($params['id']);
    	}else{
    		$addi->setCtime(date('Y-m-d H:i:s'));
    	}
    	if($validate->isValid($params['did'])){
    		$addi->setDestination_id($params['did']);
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
    			Application_Model_M_DestinationAdditional::updateImage($id, $img);
    		}
    		 
    		$url = '/destination/addiview?id='.$id.'&from=add&did='.$params['did'].'&hmsg='.$hmsg;
    		$this->redirect($url);
    	}catch (Zend_Db_Exception $e){
    		$this->redirect('/error?message='.$e->getMessage());
    	}
    }
    
    public function hospitaladdAction(){
    	$page	= $this->_getParam('page',1);
    	$did	= $this->_getParam('id');
    	$hname	= $this->_getParam('hname',NULL);
    	$this->view->did = $did;
    	if($hname){
    		$hospitals	= Application_Model_M_Hospital::fetchByNamePage($hname,$page,30);
    	}else{
    		$hospitals	= Application_Model_M_Hospital::fetchByStatus('all',$page,30);
    	}
    	$this->view->hospitals = $hospitals;
    }

    
    public function hospitaldetailAction(){
    	$did	= $this->_getParam('id');
    	$maps = Application_Model_M_DestinationHospitalMap::fetchByDestinationID($did);
    	$hospitals = array();
    	if(count($maps)>0){
    		foreach ($maps as $map){
    			$hid = $map->getHospital_id();
    			$hospital = Application_Model_M_Hospital::find($hid);
    			if($hospital){
    				array_push($hospitals, $hospital);
    			}
    		}
    	}
    	$this->view->hospitals = $hospitals;
    	$this->view->did	= $did;
    }
    

    
    public function hospitalcancelAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	
    	$did = $this->_getParam('did');
    	$hid = $this->_getParam('hid');
    	try {
    		Application_Model_M_DestinationHospitalMap::delByDidAndHid($did,$hid);
    		$out['errno'] = "0";
    	}catch(Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	}
    	Yy_Utils::jsonOut($out);
    }
    

    
    public function hospitaladdajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$did = $this->_getParam('did');
    	$hid = $this->_getParam('hid');
    	$map = new Application_Model_O_DestinationHospitalMap();

    	if($did && $hid){
    		$map
    			->setDestination_id($did)
    			->setHospital_id($hid)
    			->setCtime(date('Y-m-d H:i:s'))
    			;
    	}
    	try {
    		$out['errno'] = "0";
    		$map->save();
    	}catch (Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	} 
    	Yy_Utils::jsonOut($out);	
    }
    
    
    public function traveladdAction(){
    	$page	= $this->_getParam('page',1);
    	$did	= $this->_getParam('id');
    	$area	= $this->_getParam('area',NULL);
    	$title	= $this->_getParam('title',NULL);
    	$this->view->did	= $did;
    	if($area){
    		$travels	= Application_Model_M_Travel::fetchByAreaPage($area,$page,30);
    	}elseif($title){
    		$travels	= Application_Model_M_Travel::fetchByTitlePage($title,$page,30);
    	}else{
    		$travels	= Application_Model_M_Travel::fetchByStatus('all',$page,30);
    	}
    	$this->view->travels	= $travels;
    }
    
    public function traveldetailAction(){
    	$did	= $this->_getParam('id');
    	$maps = Application_Model_M_DestinationTravelMap::fetchByDestinationID($did);
    	$travels = array();
    	if(count($maps)>0){
    		foreach ($maps as $map){
    			$tid = $map->getTravel_id();
    			$travel	= Application_Model_M_Travel::find($tid);
    			if($travel){
    				array_push($travels, $travel);
    			}
    		}
    	}
    	$this->view->travels = $travels;
    	$this->view->did	= $did;
    }
        
    public function travelcancelAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    
    	$did = $this->_getParam('did');
    	$tid = $this->_getParam('tid');
    	try {
    		Application_Model_M_DestinationTravelMap::delByDidAndTid($did,$tid);
    		$out['errno'] = "0";
    	}catch(Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	}
    	Yy_Utils::jsonOut($out);
    }    
    
    
    public function traveladdajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    
    	$did = $this->_getParam('did');
    	$tid = $this->_getParam('tid');
    	$map = new Application_Model_O_DestinationTravelMap();
    	if($did && $tid){
    		$map
    			->setDestination_id($did)
    			->setTravel_id($tid)
    			->setCtime(date('Y-m-d H:i:s'))
    			;
    	}
    	try {
    		$out['errno'] = "0";
    		$map->save();
    	}catch (Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	}
    	Yy_Utils::jsonOut($out);
    }

    public function deleteAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$id = $this->_getParam('id');
    	try {
			Yy_Utils::RDelByDestinationID($id);
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
    		Application_Model_M_DestinationAdditional::delById($id);
    		$out['errno'] = "0";
    	}catch(Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	}
    	Yy_Utils::jsonOut($out);
    }
    
    
    public function importAction(){	 
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
    				$destinations = array();
    				foreach ($sheetData as $record){
    					$destination = new Application_Model_O_Destination();
						$destination->setCity($record['A']);
    					if($record['B'] == '国内'){
    						$type = 1;
    					}elseif ($record['B'] == '国外'){
    						$type = 2;
    					}else{
    						continue;
    					}
    					$destination->setType($type);
    					$destination
    								->setLongitude($record['C'])
    								->setLatitude($record['D'])
    								->setSort($record['E'])
    								;
    					if($record['F'] == '正常'){
    						$status = 1;
    					}elseif ($record['F'] == '禁用'){
    						$status = 0;
    					}else{
    						continue;
    					}
    					$destination->setStatus($status);
    					try {
    						$destination->setCtime(date('Y-m-d H:i:s'));
    						$destination->save();
    						array_push($destinations, $destination);
    						$this->view->destinations = $destinations;
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

