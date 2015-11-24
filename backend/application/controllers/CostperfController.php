<?php

class CostperfController extends Zend_Controller_Action{

    public function init(){
//     	$this->getResponse()->setHeader('Content-Type', 'application/json');
//         $this->_helper->viewRenderer->setNoRender(true);
//         $this->_helper->layout()->disableLayout();       
    }

    public function indexAction(){
    	
    }
    
    public function cateaddAction(){
    	
    }
    
    public function catedetailAction(){
    	$data	= Application_Model_M_DepartmentsCategory::fetchAll();
    	$this->view->data = $data;   	
    }
    
    public function catedelAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$id = $this->_getParam('cid');
    	try {
    		Application_Model_M_DepartmentsCategory::delById($id);
    		$out['errno'] = "0";
    	}catch(Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	}
    	Yy_Utils::jsonOut($out);   	
    }
    
    public function cateviewAction(){
        $id = $this->_getParam('id');
    	$cate = Application_Model_M_DepartmentsCategory::find($id);
    	if($cate){
    		$this->view->cate = $cate;
    	}else{
    		$this->redirect('/error');
    	}
    	
    }
    
    public function cateupdateAction(){
    	$id  = $this->_getParam('id');
    	$cate = Application_Model_M_DepartmentsCategory::find($id);
    	if($cate){
    		$this->view->cate = $cate;
    	}else{
    		$this->redirect('error');
    	}    
    }
    
    public function cateimageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
    	$id = $this->_getParam('id');
    	$img = Application_Model_M_DepartmentsCategory::getImage($id);
    	echo $img;    	
    }
    
    public function cateasyncajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$params = $this->_getAllParams();
    	$cate = new Application_Model_O_DepartmentsCategory();
    	$validate = new Yy_Validate_Value();
    	if($validate->isValid($params['id'])){
    		$cate->setId($params['id']);
    	}else{
    		$cate->setCtime(date('Y-m-d H:i:s'));
    	}
    	if($validate->isValid($params['name'])){
    		$cate->setName($params['name']);
    	}
    	if($validate->isValid($params['sort'])){
    		$cate->setSort($params['sort']);
    	}
    	if($validate->isValid($params['status'])){
    		$cate->setStatus($params['status']);
    	}
    	
    	try{
    		$cate->save();
    		$id = $cate->getId();
    		 
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
    			Application_Model_M_DepartmentsCategory::updateImage($id, $img);
    		}
    		 
    		$url = '/costperf/cateview?id='.$id.'&from=add';
    		$this->redirect($url);
    	}catch (Zend_Db_Exception $e){
    		$this->redirect('/error?message='.$e->getMessage());
    	}
    	
    }
    
    public function detailAction(){
    	$page  = $this->_getParam('page',1);
    	$data	= Application_Model_M_Departments::fetchAllPage($page,30);
    	$this->view->data = $data;
    	$this->view->page = $page;
    	
    }
    
    public function viewAction(){
    	$id = $this->_getParam('id');
    	$depart = Application_Model_M_Departments::find($id);
    	if($depart){
    		$this->view->depart = $depart;
    	}else{
    		$this->redirect('/error');
    	}
    }
    
    public function updateAction(){
    	$id  = $this->_getParam('id');
    	$depart = Application_Model_M_Departments::find($id);
    	if($depart){
    		$this->view->depart = $depart;
    	}else{
    		$this->redirect('error');
    	}    	
    }
    
    public function asyncajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	
    	$params = $this->_getAllParams();
    	//echo "<pre>";var_dump($params);exit;
    	$depart = new Application_Model_O_Departments();
    	$validate = new Yy_Validate_Value();
    	if($validate->isValid($params['id'])){
    		$depart->setId($params['id']);
    	}else{
    		$depart->setCtime(date('Y-m-d H:i:s'));
    	}
    	if($validate->isValid($params['name'])){
    		$depart->setName($params['name']);
    	}
    	if($validate->isValid($params['category_id'])){
    		$depart->setCategory_id($params['category_id']);
    	}
    	if($validate->isValid($params['sort'])){
    		$depart->setSort($params['sort']);
    	}
    	if($validate->isValid($params['status'])){
    		$depart->setStatus($params['status']);
    	}
    	
    	
    	try{
    		$depart->save();
    		$id = $depart->getId();
    		 
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
    			//Application_Model_M_DepartmentsCategory::updateImage($id, $img);
    			Application_Model_M_Departments::updateImage($id, $img);
    		}
    		 
    		$url = '/costperf/view?id='.$id;
    		$this->redirect($url);
    	}catch (Zend_Db_Exception $e){
    		$this->redirect('/error?message='.$e->getMessage());
    	}
    }
    
    public function imageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
    	$id = $this->_getParam('id');
    	$img = Application_Model_M_Departments::getImage($id);
    	echo $img;    	
    }
    
    public function addAction(){
    	
    }
    
    public function addidetailAction(){
    	$did = $this->_getParam('id',NULL);
    	$results = Application_Model_M_DepartmentsAdditional::fetchByDepartmentID($did);
    	$res1 = array();
    	$res2 = array();
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
    	$addi = Application_Model_M_DepartmentsAdditional::find($id);
    	if($addi){
    		$this->view->addi = $addi;
    	}else{
    		$this->redirect('/error');
    	}
    }
    
    public function addiupdateAction(){
    	$id  = $this->_getParam('id');
    	$addi = Application_Model_M_DepartmentsAdditional::find($id);
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
    	$img = Application_Model_M_DepartmentsAdditional::getImage($id);
    	echo $img;
    }    
    
    public function addiasyncajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$params = $this->_getAllParams();
    	$hmsg = $this->_getParam('hmsg');
    	//    	echo "<pre>";var_dump($params);exit;
    	$addi = new Application_Model_O_DepartmentsAdditional();
    	$validate = new Yy_Validate_Value();
    	if($validate->isValid($params['id'])){
    		$addi->setId($params['id']);
    	}else{
    		$addi->setCtime(date('Y-m-d H:i:s'));
    	}
    	if($validate->isValid($params['did'])){
    		$addi->setDepartment_id($params['did']);
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
    		 
    		//保存热门项目附件信息图片
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
    			Application_Model_M_DepartmentsAdditional::updateImage($id, $img);
    		}
    		 
    		$url = '/costperf/addiview?id='.$id.'&from=add&did='.$params['did'].'&hmsg='.$hmsg;
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
    	$maps	= Application_Model_M_DepartmentsHospitalMap::fetchByDepartmentID($did);
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
    		Application_Model_M_DepartmentsHospitalMap::delByDidAndHid($did,$hid);
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
    //var_dump($this->_getAllParams());exit;
    	$did = $this->_getParam('did');
    	$hid = $this->_getParam('hid');
    	$map = new Application_Model_O_DepartmentsHospitalMap();
    //var_dump($map);exit;
    	if($did && $hid){
    		$map
	    		->setDepartment_id($did)
	    		->setHospital_id($hid)
	    		->setCtime(date('Y-m-d H:i:s'))
	    		;
    	}
    	try {
    		$out['errno'] = "0";
    		$map->save();
    	}catch (Zend_Db_Exception $e){
    		$out['errno'] = "1";
    		$out['msg']	= $e->getMessage();
    	}
    	Yy_Utils::jsonOut($out);
    }
    

    public function deleteAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$id = $this->_getParam('id');
    	try {
    		Yy_Utils::RDelByDepartmentID($id);
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
    		Application_Model_M_DepartmentsAdditional::delById($id);
    		$out['errno'] = "0";
    	}catch(Zend_Db_Exception $e){
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
    	$maps	= Application_Model_M_DepartmentsTravelMap::fetchByDepartID($did);
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
    		Application_Model_M_DepartmentsTravelMap::delByDidAndTid($did,$tid);
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
    	$map	= new Application_Model_O_DepartmentsTravelMap();
    	if($did && $tid){
    		$map
    			->setDepartment_id($did)
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



}

