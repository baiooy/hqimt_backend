<?php

class DoctorController extends Zend_Controller_Action
{
    protected $_auth;

    public function init(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->_helper->viewRenderer->setNoRender(true); 
        $this->_helper->layout()->disableLayout();
        $this->_auth = new Zend_Session_Namespace('auth');
    }
    
    /*
     * 医生登录
     */
    public function loginAction(){
    	$account   = $this->_getParam('account');
    	$passwd    = md5($this->_getParam('passwd'));
    
    	$validatorEmail  = new Zend_Validate_EmailAddress();
    	if($validatorEmail->isValid($account)){//账户名符合规则
    		$doctor    = Application_Model_M_Doctor::fetchByEmailAndPasswd($account,$passwd);
    	}else{
    		$out['errno'] = '1';
    		$out['msg']   = Yy_ErrMsg_Doctor::getMsg('login', $out['errno']);
    		Yy_Utils::jsonOut($out);
    		return;
    	}
    
    	if($doctor){//登录成功
    		$out['errno'] = '0';
    		$out['id']	= $doctor->getId();
    		$out['role']= 2;
    		$this->_auth->userid = $doctor->getId();
    		$this->_auth->role  = 2;
    	}else{//登录失败
    		$out['errno'] = '1';
    	}
    	$out['msg'] = Yy_ErrMsg_Doctor::getMsg('login', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    /*
     * 医生退出
     */
    public function logoutAction(){
    	Zend_Session::destroy();
    	$out['errno'] = '0';
    	$out['msg']   = Yy_ErrMsg_Doctor::getMsg('logout', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    /*
     * 医生注册
     */
    public function registerAction(){
    	$name   = $this->_getParam('name');
    	$avatar = $this->_getParam('avatar');
    	$sex    = $this->_getParam('sex');
    	$birthday = $this->_getParam('birthday');
    	$email  = $this->_getParam('email');
    	$passwd = $this->_getParam('passwd');
    	$phone  = $this->_getParam('phone');
    	$department = $this->_getParam('department');
    	$city       = $this->_getParam('city');
    	//$certified  = $this->_getParam('certified');
    	$special    = $this->_getParam('special');
    	$country    = $this->_getParam('country');
    	$introduction   = $this->_getParam('introduction');
    	$hospital       = $this->_getParam('hospital');
    	$area       = $this->_getParam('area');
    	$qualification  = $this->_getParam('qualification');
    
    	if(!$passwd){
    		$out['errno'] = '3';
    		$out['msg']   = Yy_ErrMsg_Doctor::getMsg('register', $out['errno']);
    		Yy_Utils::jsonOut($out);
    		return;
    	}
    	$validatorEmail = new Zend_Validate_EmailAddress();
    	if($validatorEmail->isValid($email)){
    		$bool = Application_Model_M_Doctor::fetchByEmail($email);
    		if($bool){//已注册
    			$out['errno'] = '1';
    		}else{
    			$out['errno'] = '0';
    			$doctor = new Application_Model_O_Doctor();
    			$doctor ->setName($name)
            			//->setAvatar($avatar)
            			->setSex($sex)
            			->setBirthday($birthday)
            			->setEmail($email)
            			->setPasswd(md5($passwd))
            			->setPhone($phone)
            			->setDepartment($department)
            			->setCity($city)
            			->setSpecial($special)
            			->setCountry($country)
            			->setIntroduction($introduction)
            			->setHospital($hospital)
            			->setArea($area)
            			->setQualification($qualification)
            			->setCtime(date('Y-m-d H:i:s'))
            			;
    			$certified = ceil(count($doctor->getModifiedFields())/3);
    			$doctor->setCertified($certified);
    			$doctor->save();
    			//保存医生头像
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
    				Application_Model_M_Doctor::updateAvatar($doctor->getId(),$avatar);
    			}
    		}
    	}else{
    		$out['errno'] = '2';
    	}
    	$out['msg']   = Yy_ErrMsg_Doctor::getMsg('register', $out['errno']);
    	Yy_Utils::jsonOut($out);
    	 
    }
    /*
     * 医生更新自己的信息
     */
    public function updateAction(){
    	$name = $this->_getParam('name');
    	$avatar = $this->_getParam('avatar');
    	$sex = $this->_getParam('sex');
    	$birthday = $this->_getParam('birthday');
    	$passwd = $this->_getParam('passwd');
    	$phone  = $this->_getParam('phone');
    	$department = $this->_getParam('department');
    	$city = $this->_getParam('city');
    	$special = $this->_getParam('special');
    	$country = $this->_getParam('country');
    	$introduction = $this->_getParam('introduction');
    	$hospital = $this->_getParam('hospital');
    	$area = $this->_getParam('area');
    	$qualification = $this->_getParam('qualification');
    	if($this->_auth->userid && $this->_auth->role == 2){
    		$doctor = Application_Model_M_Doctor::find($this->_auth->userid);
    		if($doctor){
    			if($name){
    				$doctor->setName($name);
    			}
//     			if($avatar){
//     				//$doctor->setAvatar($avatar);
//     				Application_Model_M_Doctor::updateAvatar($this->_auth->userid, addslashes($avatar));
//     			}
    			if($sex){
    				$doctor->setSex($sex);
    			}
    			if($birthday){
    				$doctor->setBirthday($birthday);
    			}
    			if($passwd){
    				$doctor->setPasswd(md5($passwd));
    			}
    			if($phone){
    				$doctor->setPhone($phone);
    			}
    			if($department){
    				$doctor->setDepartment($department);
    			}
    			if($city){
    				$doctor->setCity($city);
    			}
    			if($special){
    				$doctor->setSpecial($special);
    			}
    			if($country){
    				$doctor->setCountry($country);
    			}
    			if($introduction){
    				$doctor->setIntroduction($introduction);
    			}
    			if($hospital){
    				$doctor->setHospital($hospital);
    			}
    			if($area){
    				$doctor->setArea($area);
    			}
    			if($qualification){
    				$doctor->setQualification($qualification);
    			}
    			
    			try {
    				$out['errno'] = '0';
    				$doctor->save();
    				//保存医生头像
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
    					Application_Model_M_Doctor::updateAvatar($doctor->getId(),$avatar);
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
    	$out['msg']   = Yy_ErrMsg_Doctor::getMsg('update', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    public function viewAction(){
    	if($this->_auth->userid && $this->_auth->role == 2){
    	    $doctor = Application_Model_M_Doctor::find($this->_auth->userid);
    	    if($doctor){
    	    	$out['errno'] = '0';
    	    	$out['name'] = $doctor->getName();
    	    	$out['avatar'] = Application_Model_M_Doctor::getAvatarUrl($doctor->getId());
    	    	$out['sex'] = $doctor->getSex();
    	    	$out['birthday'] = $doctor->getBirthday();
    	    	$out['email'] = $doctor->getEmail();
    	    	$out['phone'] = $doctor->getPhone();
                $out['department'] = $doctor->getDepartment();
                $out['city'] = $doctor->getCity();
                $out['special'] = $doctor->getSpecial();
                $out['country'] = $doctor->getCountry();
                $out['introduction'] = $doctor->getIntroduction();
                $out['hospital'] = $doctor->getHospital();
                $out['area'] = $doctor->getArea();
                $out['qualification'] = $doctor->getQualification();
    	    }else{
    	    	$out['errno'] = '1';
    	    }
    	}else{
    	    $out['errno'] = '200';
    	}
    	$out['msg'] =  Yy_ErrMsg_Doctor::getMsg('view', $out['errno']);
        Yy_Utils::jsonOut($out);
    }
    /*
     * 医生认证查看
     */
    public function certlevelAction(){
    	if($this->_auth->userid && $this->_auth->role == 2){
    		$doctor = Application_Model_M_Doctor::find($this->_auth->userid);
    		if($doctor){
    			$out['errno'] = '0';
    			$out['certlevel'] = $doctor->getCertified();
    		}else{
    			$out['errno'] = '1';
    		}
    	}else{
    		$out['errno'] = '200';
    	}
    	$out['msg'] = Yy_ErrMsg_Doctor::getMsg('certlevel', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    /*
     * 医生订单管理
     */
    public function orderlistAction(){
        if($this->_auth->userid && $this->_auth->role == 2){
            $cardOrders = Application_Model_M_MemberCardOrder::fetchByDoctor($this->_auth->userid);
            $reservationOrders = Application_Model_M_ReservationOrder::fetchByDoctor($this->_auth->userid);
            $travelOrders   = Application_Model_M_TravelOrder::fetchByDoctor($this->_auth->userid);
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
        $out['msg'] = Yy_ErrMsg_Doctor::getMsg('order', $out['errno']);
        Yy_Utils::jsonOut($out);
    }
    
    public function pointAction(){
        if($this->_auth->userid && $this->_auth->role == 2){
        	$doctor = Application_Model_M_Doctor::find($this->_auth->userid);
        	if($doctor){
        		$out['errno'] = '0';
        		$out['point'] = $doctor->getPoint();
        	}else{
        		$out['errno'] = '1';
        	}
        }else{
        	$out['errno'] = '200';
        }
        $out['msg'] = Yy_ErrMsg_Doctor::getMsg('point', $out['errno']);
        Yy_Utils::jsonOut($out);
    }
    
    public function imAction(){
    	 
    }
    
    /*
     * 医生信息，供其他用户查看
     */
    public function infoAction(){
    	$id = $this->_getParam('id');
    	$doctor = Application_Model_M_Doctor::find($id);
    	if($doctor && $doctor->getStatus() == 1){
    		$out['errno'] = '0';
    		$out['id']	= $doctor->getId();
    		$out['name']  = $doctor->getName();
    		$out['avatar'] =  Application_Model_M_Doctor::getAvatarUrl($doctor->getId());
    		$out['sex']   = $doctor->getSex();
    		$out['birthday'] = $doctor->getBirthday();
    		//$out['phone']    = $doctor->getPhone();
    		$out['department'] = $doctor->getDepartment();
    		$out['city']  = $doctor->getCity();
    		$out['certified'] = $doctor->getCertified();
    		$out['special']   = $doctor->getSpecial();
    		$out['country']   = $doctor->getCountry();
    		$out['introduction']  = $doctor->getIntroduction();
    		$out['hospital']  = $doctor->getHospital();
    		$out['area']      = $doctor->getArea();
    		$out['qualification'] = $doctor->getQualification();
    		$out['reservation_fee']     = $doctor->getReservation_fee();
    		$out['reservation_number']  = $doctor->getReservation_number();  
    	}else{
    		$out['errno'] = '1';
    	}
    	$out['msg'] = Yy_ErrMsg_Doctor::getMsg('info', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    public function imageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    
    	$id = $this->_getParam('id');
    	$avatar = Application_Model_M_Doctor::getAvatar($id);
    	echo $avatar;
    }
}