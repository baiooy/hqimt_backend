<?php
/*
 * Destination
 */
class DestinationController extends Zend_Controller_Action
{
//    protected $_auth;

    public function init(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->_helper->viewRenderer->setNoRender(true); 
        $this->_helper->layout()->disableLayout();
//        $this->_auth = new Zend_Session_Namespace('auth');
    }
    public function indexAction(){
    	$type	= $this->_getParam('type',1);// 1国内，2国外
    	$page	= $this->_getParam('page',1);
    	$res	= Application_Model_M_Destination::fetchByType($type,$page);
    	$destinations	= $res['destinations'];
    	$pages			= $res['pages'];
    	if(count($destinations)>0){
    		$out['errno'] = '0';
    		if($page < $pages){
    			$out['page']  = $page;
    		}else{
    			$out['page'] = $pages;
    		}
    		$out['pages'] = $pages;
    		$results = array();
    		foreach ($destinations as $destination){
    			$result = array(
    					'id'	=> $destination->getId(),
    					'img'	=> Application_Model_M_Destination::getImageUrl($destination->getId()),
    					'city'	=> $destination->getCity(),
						'longitude'	=> $destination->getLongitude(),
						'latitude'	=> $destination->getLatitude(),
    					);
    			array_push($results, $result);
    		}
    		$out['destinations']	= $results;
    	}else{
    		$out['errno'] = '1';
    	}
    	$out['msg'] = Yy_ErrMsg_Destination::getMsg('index', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    public function detailAction(){
    	$id = $this->_getParam('id'); //destination_id
    	$type = $this->_getParam('type'); //1医疗概况,2特色景点
    	$additionals = Application_Model_M_DestinationAdditional::fetchByDestinationIDAndType($id,$type);
    	if(count($additionals)>0){
    		$out['errno'] = '0';
    		$details = array();
    		foreach ($additionals as $additional){
    			$detail = array(
    					'title'     => $additional->getTitle(),
    					'content'   => $additional->getContent(),
    					'img'       => Application_Model_M_DestinationAdditional::getImageUrl($additional->getId()),
    					);
    			array_push($details, $detail);
    		}
    		$out['details']   = $details;
    	}else{
    		$out['errno'] = '1';
    	}
    	$out['msg'] = Yy_ErrMsg_Destination::getMsg('detail', $out['errno']);
    	Yy_Utils::jsonOut($out);
    	
    }
    
    public function imageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    
    	$id = $this->_getParam('id');
    	$img = Application_Model_M_Destination::getImage($id);
    	echo $img;
    }
    public function addiimageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    
    	$id = $this->_getParam('id');
    	$img = Application_Model_M_DestinationAdditional::getImage($id);
    	echo $img;
    }
    
    /*
     * 推荐医院
     */
    public function hospitalAction(){
    	$id	= $this->_getParam('id');//destination_id
    	$hospitalMaps = Application_Model_M_DestinationHospitalMap::fetchByDestinationID($id);
    	if(count($hospitalMaps)>0){
    		$hospitals	= array();
    		foreach ($hospitalMaps as $hospitalMap){
    			$hospitalID = $hospitalMap->getHospital_id();
    			$hospitalModel	= Application_Model_M_Hospital::find($hospitalID);
    			if($hospitalModel && $hospitalModel->getStatus() == 1){
    				$hospital = array(
    						'id'	=> $hospitalModel->getId(),
    						'name'	=> $hospitalModel->getName(),
    						'avatar'=> Application_Model_M_Hospital::getAvatarUrl($hospitalModel->getId()),
    						'type'	=> $hospitalModel->getType(),
    						'departments'	=> $hospitalModel->getDepartments(),
							'longitude'	=> $hospitalModel->getLongitude(),
							'latitude'	=> $hospitalModel->getLatitude(),
    						);
    				array_push($hospitals, $hospital);
    			}
    		}
    		if(count($hospitals)>0){
    			$out['errno'] = '0';
    			$out['hospitals'] = $hospitals;
    		}else{
    			$out['errno'] = '1';
    		}
    	}else{
    		$out['errno'] = '1';
    	}
    	$out['msg'] = Yy_ErrMsg_Destination::getMsg('hospital', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    /*
     * 推荐行程
     */
    public function travelAction(){
        $id	= $this->_getParam('id');//destination_id
        $travelMaps = Application_Model_M_DestinationTravelMap::fetchByDestinationID($id);
        if(count($travelMaps)>0){
        	$travels   = array();
        	foreach ($travelMaps as $travelMap){
        		$travelID = $travelMap->getTravel_id();
        		$travel  = Application_Model_M_Travel::find($travelID);
        		if($travel && $travel->getStatus() == 1){
        			$result  = array(
        			        'id'        => $travel->getId(),
        			        'title'     => $travel->getTitle(),
        			        'subtitle'  => $travel->getSubtitle(),
        			        'img'       => Application_Model_M_Travel::getImageUrl($travel->getId()),
        			        'adult_oprice'   => $travel->getAdult_oprice(),
        			        'adult_dprice'   => $travel->getAdult_dprice(),
        			        'child_oprice'   => $travel->getChild_oprice(),
        			        'child_dprice'   => $travel->getChild_dprice(),
        			        'area'     => $travel->getArea(),
        			        'sales'    => $travel->getSales(),
        			);
        			array_push($travels, $result);
        		}
        	}
        	if(count($travels)>0){
        		$out['errno'] = '0';
        		$out['travels'] = $travels;
        	}else{
        		$out['errno'] = '1';
        	}
        }else{
        	$out['errno'] = '1';
        }
        $out['msg'] = Yy_ErrMsg_Destination::getMsg('travel', $out['errno']);
        Yy_Utils::jsonOut($out);
    }
}