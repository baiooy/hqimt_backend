<?php
/*
 * 全球会诊
 */
class DiagnosisController extends Zend_Controller_Action{

    public function init()
    {
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->_helper->viewRenderer->setNoRender(true); 
        $this->_helper->layout()->disableLayout();
    }
    
    /*
     * 全球会诊介绍
     */
    public function indexAction(){
    	$consultations  = Application_Model_M_GlobalConsultation::fetchByStatus(1);
    	if(count($consultations)>0){
    		$out['errno'] = '0';
    		$results  = array();
    		foreach ($consultations as $consultation){
    			$result = array(
    				    'title'     => $consultation->getTitle(),
    			        'content'   => $consultation->getContent(),
    			        'img'       => Application_Model_M_GlobalConsultation::getImgUrl($consultation->getId()),
    			         );
    			array_push($results, $result);
    		}
    		$out['consultations'] = $results;
    	}else{
    		$out['errno'] = '1';
    	}
    	$out['msg'] = Yy_ErrMsg_Diagnosis::getMsg('index', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    public function imageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    
    	$id = $this->_getParam('id');
    	$img = Application_Model_M_GlobalConsultation::getImage($id);
    	echo $img;
    }
    
    /*
     * 价格展示
     */
    public function priceAction(){
    	$prices    = Application_Model_M_GlobalConsultationPrice::fetchByStatus(1);
    	if(count($prices)>0){
    		$out['errno'] = '0';
    		$personal = array();
    		$company  = array();
    		$opinion  = array();
    		foreach ($prices as $price){
    		    $res = array(
        		    		'title'    => $price->getTitle(),
        		    		'content'  => $price->getContent(),
    		                );
    			if($price->getType() == 1){
    			    array_push($personal, $res);
    			}elseif($price->getType() == 2){
    				array_push($company, $res);
    			}elseif($price->getType() == 3){
    				array_push($opinion, $res);
    			}else{
    				;
    			}
    		}
    		$out['personal']  = $personal;
    		$out['company']   = $company;
    		$out['opinion']   = $opinion;
    	}else{
    		$out['errno'] = '1';
    	}
    	$out['msg'] = Yy_ErrMsg_Diagnosis::getMsg('price', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    /*
     * 提交申请
     */
    public function applyAction(){
    	$category   = $this->_getParam('category');
    	$department = $this->_getParam('department');
    	$email      = $this->_getParam('email');
    	$mobile     = $this->_getParam('mobile');
    	$age        = $this->_getParam('age');
    	$sex        = $this->_getParam('sex');
    	$location   = $this->_getParam('location');
    	$treatment_time = $this->_getParam('treatment_time');
    	$opinion    = $this->_getParam('opinion');
    	$report     = $this->_getParam('report');
    	$apply = new Application_Model_O_GlobalConsultationApply();
    	$apply
    	      ->setDepartment_category_id($category)
    	      ->setDepartment_id($department)
    	      ->setEmail($email)
    	      ->setMobile($mobile)
    	      ->setAge($age)
    	      ->setSex($sex)
    	      ->setLocation($location)
    	      ->setTreatment_time($treatment_time)
    	      ->setOpinion($opinion)
    	      ->setCtime(date('Y-m-d H:i:s'));
    	      ;
    	try{
    		$out['errno'] = '0';
    		$apply->save();
    		//保存病例报告
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
    			$report = addslashes(fread($handle, filesize($filename)));
    			fclose($handle);
    			Application_Model_M_GlobalConsultationApply::updateReport($apply->getId(),$report);
    		}
    	}catch (Zend_Db_Exception $e){
    		$out['errno'] = '1';
    		//echo $e->getMessage();
    	}
    	$out['msg'] = Yy_ErrMsg_Diagnosis::getMsg('apply', $out['errno']);
    	Yy_Utils::jsonOut($out);  	
    }
}