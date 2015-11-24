<?php

class DiagnosisController extends Zend_Controller_Action{

    public function init(){
//     	$this->getResponse()->setHeader('Content-Type', 'application/json');
//         $this->_helper->viewRenderer->setNoRender(true);
//         $this->_helper->layout()->disableLayout();       
    }

    public function indexAction(){
    	
    }

	/*
	 * 全球会诊介绍
	 */
    public function introdetailAction(){
    	$intros	= Application_Model_M_GlobalConsultation::fetchAll();
    	$this->view->intros	= $intros;
    }
    
    public function introviewAction(){
    	$id	= $this->_getParam('id');
    	$intro	= Application_Model_M_GlobalConsultation::find($id);
    	if($intro){
    		$this->view->intro = $intro;
    	}else{
    		$this->redirect('/error');
    	}
    }
    
    public function introimageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
    	$id = $this->_getParam('id');
    	$img = Application_Model_M_GlobalConsultation::getImage($id);
    	echo $img;
    }
    
    public function introaddAction(){
    	
    }
    
    public function introupdateAction(){
    	$id = $this->_getParam('id');
    	$intro	= Application_Model_M_GlobalConsultation::find($id);
    	if($intro){
    		$this->view->intro = $intro;
    	}else{
    		$this->redirect('error');
    	}   	
    }
    
    public function introasyncajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	
    	$params = $this->_getAllParams();
    	$intro = new Application_Model_O_GlobalConsultation();
    	$validate = new Yy_Validate_Value();
    	if($validate->isValid($params['id'])){
    		$intro->setId($params['id']);
    	}else{
    		$intro->setCtime(date('Y-m-d H:i:s'));
    	}
    	if($validate->isValid($params['title'])){
    		$intro->setTitle($params['title']);
    	}
    	if($validate->isValid($params['content'])){
    		$intro->setContent($params['content']);
    	}
    	if($validate->isValid($params['sort'])){
    		$intro->setSort($params['sort']);
    	}    	
    	if($validate->isValid($params['status'])){
    		$intro->setStatus($params['status']);
    	}
    	
    	try{
    	
    		$intro->save();
    		$id = $intro->getId();
    		
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
    			Application_Model_M_GlobalConsultation::updateImage($id, $img);
    		}
    	
    	
    	
    		$url = '/diagnosis/introview?id='.$id;
    		$this->redirect($url);
    	}catch (Zend_Db_Exception $e){
    		//$this->redirect('/error');
    		$this->redirect('/error?message='.$e->getMessage());
    	}
    }
    
    public function introdelAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	
    	$id = $this->_getParam('id');
    	try {
    		Application_Model_M_GlobalConsultation::delById($id);
    		$out['errno'] = "0";
    	}catch(Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	}
    	Yy_Utils::jsonOut($out);    	
    }
    
    /*
     * 全球会诊价格
     */
    public function pricedetailAction(){
    	$prices	= Application_Model_M_GlobalConsultationPrice::fetchAll();
    	$this->view->prices	= $prices;
    }
    public function priceviewAction(){
    	$id	= $this->_getParam('id');
    	$price	= Application_Model_M_GlobalConsultationPrice::find($id);
    	if($price){
    		$this->view->price = $price;
    	}else{
    		$this->redirect('/error');
    	}    	
    }
    public function priceaddAction(){
    	
    }
    
    public function priceupdateAction(){
    	$id = $this->_getParam('id');
    	$price	= Application_Model_M_GlobalConsultationPrice::find($id);
    	if($price){
    		$this->view->price = $price;
    	}else{
    		$this->redirect('error');
    	}   	
    }
    
    public function priceasyncajaxAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$params = $this->_getAllParams();
    	$price = new Application_Model_O_GlobalConsultationPrice();
    	$validate = new Yy_Validate_Value();
    	if($validate->isValid($params['id'])){
    		$price->setId($params['id']);
    	}else{
    		$price->setCtime(date('Y-m-d H:i:s'));
    	}
    	if($validate->isValid($params['type'])){
    		$price->setType($params['type']);
    	}
    	if($validate->isValid($params['title'])){
    		$price->setTitle($params['title']);
    	}
    	if($validate->isValid($params['content'])){
    		$price->setContent($params['content']);
    	}
    	if($validate->isValid($params['sort'])){
    		$price->setSort($params['sort']);
    	}
    	if($validate->isValid($params['status'])){
    		$price->setStatus($params['status']);
    	}
    	try{
    		$price->save();
    		$id = $price->getId();    		 
    		$url = '/diagnosis/priceview?id='.$id;
    		$this->redirect($url);    		
    	}catch (Zend_Db_Exception $e){
    		$this->redirect('/error?message='.$e->getMessage());
    	}
    }
    
    public function pricedelAction(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
    	$this->_helper->viewRenderer->setNoRender(true);
    	$this->_helper->layout()->disableLayout();
    	 
    	$id = $this->_getParam('id');
    	try {
    		Application_Model_M_GlobalConsultationPrice::delById($id);
    		$out['errno'] = "0";
    	}catch(Zend_Db_Exception $e){
    		$out['errno'] = "1";
    	}
    	Yy_Utils::jsonOut($out);
    }    
    
   	/*
   	 * 查看全球会诊申请
   	 */
	public function applydetailAction(){
		$page  = $this->_getParam('page',1);
		$data	= Application_Model_M_GlobalConsultationApply::fetchAllPage($page,20);
		$this->view->data = $data;
		$this->view->page = $page;
	}
	
	public function applyviewAction(){
		$id	= $this->_getParam('id');
		$apply	= Application_Model_M_GlobalConsultationApply::find($id);
		if($apply){
			$this->view->apply = $apply;
		}else{
			$this->redirect('/error');
		}		
	}
	public function applyimageAction(){
		$this->getResponse()->setHeader('Content-Type', 'image/png');
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		 
		$id = $this->_getParam('id');
		$img = Application_Model_M_GlobalConsultationApply::getImage($id);
		echo $img;		
	}
	
	public function applydelAction(){
		$this->getResponse()->setHeader('Content-Type', 'application/json');
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
		
		$id = $this->_getParam('id');
		try {
			Application_Model_M_GlobalConsultationApply::delById($id);
			$out['errno'] = "0";
		}catch(Zend_Db_Exception $e){
			$out['errno'] = "1";
		}
		Yy_Utils::jsonOut($out);		
	}

	
	/*
	 * 新增会诊申请项目类型
	 */
	public function departaddAction(){
		
	}
	/*
	 * 
	 */
	public function departasyncajaxAction(){
		$this->getResponse()->setHeader('Content-Type', 'application/json');
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
		
		$params = $this->_getAllParams();
		//var_dump($params);exit;
		$depart = new Application_Model_O_ConsultationDepartments();
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
			$url = '/diagnosis/departview?id='.$id;
			$this->redirect($url);
		}catch (Zend_Db_Exception $e){
			echo $e->getMessage();
			$this->redirect('/error?message='.$e->getMessage());
		}
		
		
	}
	/*
	 * 会诊申请的项目类型
	 */
	public function departdetailAction(){
		$page = $this->_getParam('page',1);
		$data = Application_Model_M_ConsultationDepartments::fetchAllPage($page,30);
		$this->view->data = $data;
		$this->view->page = $page;
	}
	/*
	 * 会诊申请项目类型详情
	 */
	public function departviewAction(){
		$id	= $this->_getParam('id');
		$depart	= Application_Model_M_ConsultationDepartments::find($id);
		if($depart){
			$this->view->depart = $depart;
		}else{
			$this->redirect('/error');
		}
	}
	/*
	 * 修改会诊申请项目类型
	 */
	public function departupdateAction(){
		$id = $this->_getParam('id');
		$depart	= Application_Model_M_ConsultationDepartments::find($id);
		if($depart){
			$this->view->depart = $depart;
		}else{
			$this->redirect('error');
		}		
	}
	
	public function departdelAction(){
		$this->getResponse()->setHeader('Content-Type', 'application/json');
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
		
		$id = $this->_getParam('id');
		try {
			Application_Model_M_ConsultationDepartments::delById($id);

			$out['errno'] = "0";
		}catch(Zend_Db_Exception $e){
			$out['errno'] = "1";
		}
		Yy_Utils::jsonOut($out);		
	}
	public function departcatedetailAction(){
		$data	= Application_Model_M_ConsultationDepartmentsCategory::fetchAll();
		$this->view->data = $data;
	}
	public function departcateaddAction(){
		
	}
	public function departcatedelAction(){
		$this->getResponse()->setHeader('Content-Type', 'application/json');
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
	
		$id = $this->_getParam('cid');
		try {
			Application_Model_M_ConsultationDepartmentsCategory::delById($id);
			$out['errno'] = "0";
		}catch(Zend_Db_Exception $e){
			$out['errno'] = "1";
		}
		Yy_Utils::jsonOut($out);
	}
	public function departcateasyncajaxAction(){
		$this->getResponse()->setHeader('Content-Type', 'application/json');
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
		
		$params = $this->_getAllParams();
		//echo "<pre>";var_dump($params);exit;
		$cate = new Application_Model_O_ConsultationDepartmentsCategory();
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
			$url = '/diagnosis/departcateview?id='.$id;
			if($validate->isValid($params['from'])){
				$url = $url.'&from='.$params['from'];
			}
			if($validate->isValid($params['did'])){
				$url = $url.'&did='.$params['did'];
			}
			$this->redirect($url);
		}catch (Zend_Db_Exception $e){
			echo $e->getMessage();
			$this->redirect('/error?message='.$e->getMessage());
		}
	}
	
	public function departcateviewAction(){
		$id = $this->_getParam('id');
		$cate	= Application_Model_M_ConsultationDepartmentsCategory::find($id);
		if($cate){
			$this->view->cate = $cate;
		}else{
			$this->redirect('/error');
		}
	}
	
	public function departcateupdateAction(){
		$id  = $this->_getParam('id');
		$cate = Application_Model_M_ConsultationDepartmentsCategory::find($id);
		if($cate){
			$this->view->cate = $cate;
		}else{
			$this->redirect('error');
		}
	}
}

