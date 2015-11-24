<?php

class HospitalController extends Zend_Controller_Action
{
    protected $_auth;

    public function init()
    {
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->_helper->viewRenderer->setNoRender(true); 
        $this->_helper->layout()->disableLayout();
        $this->_auth = new Zend_Session_Namespace('auth');
    }
    /*
     * 医院登录
     */
    public function loginAction(){
        $account   = $this->_getParam('account');
        $passwd    = md5($this->_getParam('passwd'));
        $validatorEmail  = new Zend_Validate_EmailAddress();
        if($validatorEmail->isValid($account)){//账户名符合规则
            $hospital = Application_Model_M_Hospital::fetchByEmailAndPasswd($account,$passwd);
        }else{
            $out['errno'] = '1';
            $out['msg'] = Yy_ErrMsg_Hospital::getMsg('login', $out['errno']);
            Yy_Utils::jsonOut($out);
            return;
        }
        if($hospital){
        	$out['errno'] = '0';
        	$out['id']	= $hospital->getId();
        	$out['role']= 3;
    		$this->_auth->userid = $hospital->getId();
    		$this->_auth->role  = 3;
        }else{
        	$out['errno'] = '1';
        }
        $out['msg'] = Yy_ErrMsg_Hospital::getMsg('login', $out['errno']);
        Yy_Utils::jsonOut($out);
    }
    
    public function logoutAction(){
        Zend_Session::destroy();
        $out['errno'] = '0';
        $out['msg'] = Yy_ErrMsg_Hospital::getMsg('logout', $out['errno']);
        Yy_Utils::jsonOut($out);
    }
    
    public function registerAction(){
        $name = $this->_getParam('name');
        $avatar = $this->_getParam('avatar');
        $email = $this->_getParam('email');
        $phone = $this->_getParam('phone');
        $departments = $this->_getParam('departments');
        $type = $this->_getParam('type');
        $city = $this->_getParam('city');
        $label = $this->_getParam('label');
        $country = $this->_getParam('country');
        $area = $this->_getParam('area');
        $passwd = $this->_getParam('passwd');
        $introduction = $this->_getParam('introduction');
        $longitude = $this->_getParam('longitude');
        $latitude = $this->_getParam('latitude');
        
        if(!$passwd){
        	$out['errno'] = '3';
        	$out['msg']   = Yy_ErrMsg_Hospital::getMsg('register', $out['errno']);
        	Yy_Utils::jsonOut($out);
        	return;
        }
        $validatorEmail = new Zend_Validate_EmailAddress();
        if($validatorEmail->isValid($email)){
           $bool = Application_Model_M_Hospital::fetchByEmail($email);
            if($bool){//已注册
            	$out['errno'] = '1';
            }else{
                $out['errno'] = '0';
                $hospital = new Application_Model_O_Hospital();
                $hospital
                         ->setName($name)
                         //->setAvatar($avatar)
                         ->setEmail($email)
                         ->setPasswd(md5($passwd))
                         ->setPhone($phone)
                         ->setDepartments($departments)
                         ->setType($type)
                         ->setCity($city)
                         ->setLabel($label)
                         ->setCountry($country)
                         ->setArea($area)
                         ->setIntroduction($introduction)
                         ->setLongitude($longitude)
                         ->setLatitude($latitude)
                         ;
                $certified = ceil(count($hospital->getModifiedFields())/3);
                $hospital->setCertified($certified);
                $hospital->save();
                
                //保存医院头像
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
                	$avatar = addslashes(fread($handle, filesize($filename)));
                	fclose($handle);
                	Application_Model_M_Hospital::updateAvatar($hospital->getId(),$avatar);
                }
            }
        }else{
            $out['errno'] = '2';
        }
        $out['msg']   = Yy_ErrMsg_Hospital::getMsg('register', $out['errno']);
        Yy_Utils::jsonOut($out);
    }
    
    /*
     * 医院更新自己的信息
     */
    public function updateAction(){
        $name = $this->_getParam('name');
        $avatar = $this->_getParam('avatar');
        $departments = $this->_getParam('departments');
        $type = $this->_getParam('type');
        $city = $this->_getParam('city');
        $label = $this->_getParam('label');
        $country = $this->_getParam('country');
        $area = $this->_getParam('area');
        $passwd = $this->_getParam('passwd');
        $phone  = $this->_getParam('phone');
        $introduction = $this->_getParam('introduction');
        $longitude = $this->_getParam('longitude');
        $latitude = $this->_getParam('latitude');
        if($this->_auth->userid && $this->_auth->role == 3){
        	$hospital = Application_Model_M_Hospital::find($this->_auth->userid);
        	if($hospital){
        	    if($name){
        	    	$hospital->setName($name);
        	    }
//         	    if($avatar){
//         	    	$hospital->setAvatar($avatar);
//         	    }
        	    if($departments){
        	    	$hospital->setDepartments($departments);
        	    }
        	    if($type){
        	    	$hospital->setType($type);
        	    }
        	    if($city){
        	    	$hospital->setCity($city);
        	    }
                if($label){
                	$hospital->setLabel($label);
                }
                if($country){
                	$hospital->setCountry($country);
                }
                if($area){
                	$hospital->setArea($area);
                }
                if($passwd){
                	$hospital->setPasswd(md5($passwd));
                }
                if($phone){
                	$hospital->setPhone($phone);
                }
                if($introduction){
                	$hospital->setIntroduction($introduction);
                }
                if($longitude){
                	$hospital->setLongitude($longitude);
                }
                if($latitude){
                	$hospital->setLatitude($latitude);
                }
                
                try {
                	$out['errno'] = '0';
                	$hospital->save();
                	//保存医院头像
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
                		$avatar = addslashes(fread($handle, filesize($filename)));
                		fclose($handle);
                		Application_Model_M_Hospital::updateAvatar($hospital->getId(),$avatar);
                	}
                }catch (Zend_Db_Exception $e){
                	$out['errno'] = '1';
                }
        	}else{
        		$out['errno'] = '1';
        	}
        }else{
        	$out['errno'] = '200';
        }
        $out['msg'] = Yy_ErrMsg_Hospital::getMsg('update', $out['errno']);
        Yy_Utils::jsonOut($out);
    }
    
    public function viewAction(){
        if($this->_auth->userid && $this->_auth->role == 3){
        	$hospital = Application_Model_M_Hospital::find($this->_auth->userid);
        	if($hospital){
        	    $out['errno'] = '0';
        	    $out['name'] = $hospital->getName();
        	    $out['avatar'] = Application_Model_M_Hospital::getAvatarUrl($hospital->getId());
        	    $out['departments'] = $hospital->getDepartments();
        	    $out['type'] = $hospital->getType();
        	    $out['city'] = $hospital->getCity();
        	    $out['label'] = $hospital->getLabel();
        	    $out['country'] = $hospital->getCountry();
        	    $out['area'] = $hospital->getArea();
        	    $out['email'] = $hospital->getEmail();
        	    $out['phone'] = $hospital->getPhone();
        	    $out['introduction'] = $hospital->getIntroduction();
        	    $out['longitude'] = $hospital->getLongitude();
        	    $out['latitude'] = $hospital->getLatitude();     	    
        	}else{
        	    $out['errno'] = '1';
        	}
        }else{
        	$out['errno'] = '200';
        }
        $out['msg'] = Yy_ErrMsg_Hospital::getMsg('view', $out['errno']);
        Yy_Utils::jsonOut($out);
    }
    
    /*
     * 医院认证查看
    */
    public function certlevelAction(){
    	if($this->_auth->userid && $this->_auth->role == 3){
    		$hospital = Application_Model_M_Hospital::find($this->_auth->userid);
    		if($hospital){
    			$out['errno'] = '0';
    			$out['certlevel'] = $hospital->getCertified();
    		}else{
    			$out['errno'] = '1';
    		}
    	}else{
    		$out['errno'] = '200';
    	}
    	$out['msg'] = Yy_ErrMsg_Hospital::getMsg('certlevel', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    /*
     * 医院订单管理
    */
    public function orderlistAction(){
        if($this->_auth->userid && $this->_auth->role == 3){
        	$cardOrders = Application_Model_M_MemberCardOrder::fetchByHospital($this->_auth->userid);
        	$reservationOrders = Application_Model_M_ReservationOrder::fetchByHospital($this->_auth->userid);
        	$travelOrders   = Application_Model_M_TravelOrder::fetchByHospital($this->_auth->userid);
        	$orders = array();
        	if(count($cardOrders)>0){
        		//$cards = array();
        		foreach ($cardOrders as $cardOrder){
        			$card = array(
        					'orderid'    => $cardOrder->getOrder_id(),
        					'price'      => $cardOrder->getTotal_price(),
        					'status'     => $cardOrder->getPayment_status(),
        			);
        			if(@$_GET['lang'] == 1){
        			    $remark = 'payment for buy card';
        			}else{       				
        				$remark = '购卡订单';
        			}
        			$card['remark'] = $remark;
        			array_push($orders, $card);
        		}
        	}
        	if(count($reservationOrders)>0){
        		//$reservations = array();
        		foreach ($reservationOrders as $reservationOrder){
        			$reservation = array(
        					'orderid' => $reservationOrder->getOrder_id(),
        					'price'   => $reservationOrder->getTotal_price(),
        					'status'  => $reservationOrder->getPayment_status(),
        			);
        			if(@$_GET['lang'] == 1){
        			    $remark = 'payment for reservation doctor';       				
        			}else{
        			    $remark = '咨询医生订单';
        			}
        			$reservation['remark'] = $remark;
        			array_push($orders, $reservation);
        		}
        	}
        	if(count($travelOrders)>0){
        		//$travels = array();
        		foreach ($travelOrders as $travelOrder){
        			$travel = array(
        					'orderid' => $travelOrder->getOrder_id(),
        					'price'   => $travelOrder->getTotal_price(),
        					'status'  => $travelOrder->getPayment_status(),
        			);
        			if(@$_GET['lang'] == 1){
        			    $remark = 'payment for imt';
        			}else{	
        				$remark = '医游订单';
        			}
        			$travel['remark'] = $remark;
        			array_push($orders, $travel);
        		}
        	}
        	if(count($orders)>0){
        		$out['errno'] = '0';
        		$out['orders'] = $orders;
        	}else{
        		$out['errno'] = '1';
        	}
        }else{
        	$out['errno'] = '200';
        }
        $out['msg'] = Yy_ErrMsg_Hospital::getMsg('order', $out['errno']);
        Yy_Utils::jsonOut($out);
    	 
    }
    
    public function pointAction(){
        if($this->_auth->userid && $this->_auth->role == 3){
        	$hospital = Application_Model_M_Hospital::find($this->_auth->userid);
        	if($hospital){
        		$out['errno'] = '0';
        		$out['point'] = $hospital->getPoint();
        	}else{
        		$out['errno'] = '1';
        	}
        }else{
        	$out['errno'] = '200';
        }
        $out['msg'] = Yy_ErrMsg_Hospital::getMsg('point', $out['errno']);
        Yy_Utils::jsonOut($out);
    }
    
    public function imAction(){
    	 
    }
    
    /*
     * 通过医院名称搜医院
     */
    public function searchAction(){
    	$name = $this->_getParam('name');
    	$hospitals = Application_Model_M_Hospital::fetchByName($name);
        if(count($hospitals)>0){
        	$out['errno'] = '0';
        	$results = array();
        	foreach ($hospitals as $hospital){
        		$result = array(
        			'id'     => $hospital->getId(),
        		    'name'   => $hospital->getName(),
        		    'avatar' => Application_Model_M_Hospital::getAvatarUrl($hospital->getId()),
        		    'type'   => $hospital->getType(),
        		    'departments' => $hospital->getDepartments(),
        		    'longitude'   => $hospital->getLongitude(),
        		    'latitude'    => $hospital->getLatitude(),
        		        
        		);
        		array_push($results, $result);
        	}
        	$out['hospitals']  = $results;
        }else{
        	$out['errno'] = '1';
        }
        $out['msg'] = Yy_ErrMsg_Hospital::getMsg('search', $out['errno']);
        Yy_Utils::jsonOut($out);
    	 
    }
    /*
     * 医院信息，供其他用户查看
     */
    public function infoAction(){
    	$id = $this->_getParam('id');
    	$hospital = Application_Model_M_Hospital::find($id);
    	if($hospital && $hospital->getStatus() == 1){
    		$out['errno']     = '0';
    		$out['id']        = $hospital->getId();
    		$out['name']      = $hospital->getName();
    		$out['avatar']    = Application_Model_M_Hospital::getAvatarUrl($hospital->getId());
    		$out['departments'] = $hospital->getDepartments();
    		$out['type']      = $hospital->getType();
    		$out['certified'] = $hospital->getCertified();
    		$out['city']      = $hospital->getCity();
    		$out['label']     = $hospital->getLabel();
    		$out['country']   = $hospital->getCountry();
    		$out['area']      = $hospital->getArea();
    		$out['introduction']  = $hospital->getIntroduction();
    		$out['longitude'] = $hospital->getLongitude();
    		$out['latitude']  = $hospital->getLatitude();
    		
    	}else{
    		$out['errno'] = '1';
    	}
    	$out['msg'] = Yy_ErrMsg_Hospital::getMsg('info', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    public function imageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    
    	$id = $this->_getParam('id');
    	$avatar = Application_Model_M_Hospital::getAvatar($id);
    	echo $avatar;
    }
}