<?php

class UserController extends Zend_Controller_Action
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
     * 普通用户登录
     */
    public function loginAction(){
    	$account   = $this->_getParam('account');
    	$passwd    = md5($this->_getParam('passwd'));
    	
    	$validatorEmail  = new Zend_Validate_EmailAddress();
    	$validatorMobile = new Yy_Validate_Mobile();
    	if($validatorEmail->isValid($account)){ //email
    	    $nuser = Application_Model_M_Nuser::fetchByEmailAndPasswd($account,$passwd);
    	}elseif($validatorMobile->isValid($account)){//mobile
    		$nuser = Application_Model_M_Nuser::fetchByMobileAndPasswd($account,$passwd);
    	}else{
    		$out['errno'] = '1';
            $out['msg'] = Yy_ErrMsg_User::getMsg('login', $out['errno']);
    		Yy_Utils::jsonOut($out);
    		return;
    	}
    	
    	if($nuser){//登录成功
    		$out['errno'] = '0';
    		$out['id']	= $nuser->getId();
    		$out['role']= 1; 
    		$this->_auth->userid = $nuser->getId();
    		$this->_auth->role = 1;
    	}else{//登录失败
    		$out['errno'] = '1';
    	}
    	$out['msg'] = Yy_ErrMsg_User::getMsg('login', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    /*
     * 普通用户退出
     */
    public function logoutAction(){
    	Zend_Session::destroy();
    	$out['errno'] = '0';
    	$out['msg'] = Yy_ErrMsg_User::getMsg('logout', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    /*
     * 普通用户注册，直接通过
     */
    public function registerAction(){
    	$account = $this->_getParam('account');
    	$passwd  = $this->_getParam('passwd');
    	if(!$passwd){
    		$out['errno'] = '3';
    		$out['msg'] = Yy_ErrMsg_User::getMsg('register', $out['errno']);
    		Yy_Utils::jsonOut($out);
    		return;
    	}
    	$validatorEmail = new Zend_Validate_EmailAddress();
    	$validatorMobile = new Yy_Validate_Mobile();
    	if($validatorEmail->isValid($account)){//email register
    		$bool = Application_Model_M_Nuser::fetchByEmail($account);
            if($bool){//已存在
            	$out['errno'] = '1';
            }else{
                $out['errno'] = '0';
            	$nuser = new Application_Model_O_Nuser();
            	$nuser
            	      ->setEmail($account)
            	      ->setPasswd(md5($passwd))
            	      ->setCtime(date('Y-m-d H:i:s'))
            	      ->save()
            	      ;
            }
    	}elseif($validatorMobile->isValid($account)){//mobile
    		$bool = Application_Model_M_Nuser::fetchByMobile($account);
    		if($bool){//已存在
    			$out['errno'] = '1';
    		}else{
    			$out['errno'] = '0';
    			$nuser = new Application_Model_O_Nuser();
    			$nuser
    			     ->setMobile($account)
    			     ->setPasswd(md5($passwd))
    			     ->setCtime(date('Y-m-d H:i:s'))
    			     ->save()
    			     ;
    		}
    	}else{
    		$out['errno'] = '2';
    	}
    	$out['msg'] = Yy_ErrMsg_User::getMsg('register', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    /*
     * 普通用户更新自己的信息
     */
    public function updateAction(){
        $mobile    = $this->_getParam('mobile');
        $email     = $this->_getParam('email');
    	$phone     = $this->_getParam('phone');
    	$passwd    = $this->_getParam('passwd');
    	$name      = $this->_getParam('name');
    	$avatar    = $this->_getParam('avatar');
    	$sex       = $this->_getParam('sex');
    	$job       = $this->_getParam('job');
    	$postcode  = $this->_getParam('postcode');
    	$idcard    = $this->_getParam('idcard');
    	$country   = $this->_getParam('country');
    	$address   = $this->_getParam('address');
    	$birthday  = $this->_getParam('birthday');
    	
    	$auth      = new Zend_Session_Namespace('auth');
    	if($this->_auth->userid && $this->_auth->role == 1){
    		$nuser = Application_Model_M_Nuser::find($this->_auth->userid);
    		if($nuser){
    		    if(!$nuser->getMobile()){
    		    	$validatorMobile = new Yy_Validate_Mobile();
    		    	if($validatorMobile->isValid($mobile)){
    		    		$bool = Application_Model_M_Nuser::fetchByMobile($mobile);
    		    		if(!$bool){
    		    			$nuser->setMobile($mobile);
    		    		}else{//将更新的手机号已经被注册
    		    			$out['errno'] = '2';
    		    			$out['msg']    = Yy_ErrMsg_User::getMsg('update', $out['errno']);
    		    			Yy_Utils::jsonOut($out);
    		    			return;
    		    		}
    		    	}
    		    }
    		    
    		    if(!$nuser->getEmail()){
    		    	$validatorEmail  = new Zend_Validate_EmailAddress();
    		    	if($validatorEmail->isValid($email)){
    		    		$bool = Application_Model_M_Nuser::fetchByEmail($email);
    		    		if(!$bool){
    		    			$nuser->setEmail($email);
    		    		}else{//将更新的邮箱已经被别人注册
    		    			$out['errno'] = '3';
    		    			$out['msg']    = Yy_ErrMsg_User::getMsg('update', $out['errno']);
    		    			Yy_Utils::jsonOut($out);
    		    			return;
    		    		}
    		    	}
    		    }
    		    
    			if($phone){
    				$nuser->setPhone($phone);
    			}
    			if($passwd){
    				$nuser->setPasswd(md5($passwd));
    			}
    			if($name){
    				$nuser->setName($name);
    			}
//     			if($avatar){
//     				$nuser->setAvatar($avatar);
//     			}
    			if($sex){
    				$nuser->setSex($sex);
    			}
    			if($job){
    				$nuser->setJob($job);
    			}
    			if($postcode){
    				$nuser->setPostcode($postcode);
    			}
    			if($idcard){
    				$nuser->setIdcard($idcard);
    			}
    			if($country){
    				$nuser->setCountry($country);
    			}
    			if($address){
    				$nuser->setAddress($address);
    			}
    			if($birthday){
    				$nuser->setBirthday($birthday);
    			}
    			try {
    			    $out['errno'] = '0';
    			    $nuser->save();
    			    //保存用户头像
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
    			    	Application_Model_M_Nuser::updateAvatar($nuser->getId(),$avatar);
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
        $out['msg'] = Yy_ErrMsg_User::getMsg('update', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    /*
     * 普通用户查看自己的信息
     */
    public function viewAction(){
        
    	if($this->_auth->userid && $this->_auth->role == 1){
    		$nuser  = Application_Model_M_Nuser::find($this->_auth->userid);
    		if($nuser){
    			$out['errno'] = '0';
    			$out['mobile'] = $nuser->getMobile();
    			$out['email'] = $nuser->getEmail();
    			$out['phone'] = $nuser->getPhone();
    			$out['name'] = $nuser->getName();
    			$out['avatar'] = Application_Model_M_Nuser::getAvatarUrl($nuser->getId());
    			$out['sex'] = $nuser->getSex();
    			$out['job'] = $nuser->getJob();
    			$out['postcode'] = $nuser->getPostcode();
    			$out['idcard'] = $nuser->getIdcard();
    			$out['country'] = $nuser->getCountry();
    			$out['address'] = $nuser->getAddress();
    			$out['birthday'] = $nuser->getBirthday();
    		}else{
    			$out['errno'] = '1';
    		}
    	}else{
    		$out['errno'] = '200';
    	}
    	$out['msg'] = Yy_ErrMsg_User::getMsg('view', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    /*
     * 用户订单管理
     */
    public function orderlistAction(){
        if($this->_auth->userid && $this->_auth->role == 1){
        	$cardOrders = Application_Model_M_MemberCardOrder::fetchByNuser($this->_auth->userid);
        	$reservationOrders = Application_Model_M_ConsultOrder::fetchByNuser($this->_auth->userid);
        	$travelOrders   = Application_Model_M_TravelOrder::fetchByNuser($this->_auth->userid);
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
        $out['msg'] = Yy_ErrMsg_User::getMsg('order', $out['errno']);
        Yy_Utils::jsonOut($out);
    }
    
    public function pointAction(){
        if($this->_auth->userid && $this->_auth->role == 1){
        	$nuser = Application_Model_M_Nuser::find($this->_auth->userid);
        	if($nuser){
        		$out['errno'] = '0';
        		$out['point'] = $nuser->getPoint();
        	}else{
        		$out['errno'] = '1';
        	}
        }else{
        	$out['errno'] = '200';
        }
        $out['msg'] = Yy_ErrMsg_User::getMsg('point', $out['errno']);
        Yy_Utils::jsonOut($out);
    	
    }
    
    public function imAction(){
//     	if($this->_auth->userid  && $this->_auth->role == 1){
//     		$consultingFrom = Application_Model_M_ConsultingDialog::fetchByNuserFrom($this->_auth->userid);
//     		$consultingTo = Application_Model_M_ConsultingDialog::fetchByNuserTo($this->_auth->userid);
//     		if($consultingFrom || $consultingTo){
//     			$out['errno'] = '0';
    			
//     		}else{
//     			$out['errno'] = '1';
//     		}
//     	}else{
//     		$out['errno'] = '200';
//     	}
    }
    
    public function imageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
    	$id = $this->_getParam('id');
    	$avatar = Application_Model_M_Nuser::getAvatar($id);
    	echo $avatar;    	
    }
}

