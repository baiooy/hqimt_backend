<?php
/*
 * consult
 */
class ConsultController extends Zend_Controller_Action{
    protected $_auth;

    public function init(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->_helper->viewRenderer->setNoRender(true); 
        $this->_helper->layout()->disableLayout();
        $this->_auth = new Zend_Session_Namespace('auth');
    }
    
    public function indexAction(){
    	$sort        = $this->_getParam('sort');
    	$department  = $this->_getParam('department');
    	$hospital    = $this->_getParam('hospital');
    	$page		 = $this->_getParam('page',1);
    		
    	$departmentRes = Application_Model_M_Doctor::fetchDepartment();
    	$hospitalRes   = Application_Model_M_Doctor::fetchHospital();
    	$res = Application_Model_M_Doctor::fetchByDepartmentHospital($department,$hospital,$sort,$page);
    	$doctors   = $res['doctors'];
    	$pages     = $res['pages'];
    	if(count($doctors) > 0){
    		$out['errno'] = '0';
    		if($page < $pages){
    			$out['page']  = $page;
    		}else{
    			$out['page'] = $pages;
    		}
    		$out['pages'] = $pages;
    		$out['departments'] = $departmentRes;
    		$out['hospitals']   = $hospitalRes;
    		$results = array();
    		foreach ($doctors as $doctor){
    			$result = array(
    				    'id'            => $doctor->getId(),
    			        'name'          => $doctor->getName(),
    			        'department'    => $doctor->getDepartment(),
    			        'avatar'        => Application_Model_M_Doctor::getAvatarUrl($doctor->getId()),
    			        'number'        => $doctor->getReservation_number(),
    			        'special'       => $doctor->getSpecial(),
    			        'hospital'      => $doctor->getHospital(),
    			         );
    			array_push($results, $result);
    		}
    		$out['doctors'] = $results;
    		
    	}else{
    		$out['errno'] = '1';
    	}
    	$out['msg'] = Yy_ErrMsg_Consult::getMsg('index', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    public function orderAction(){
        $id = $this->_getParam('id'); //医生ID
        if($this->_auth->userid && $this->_auth->role){
            $doctor = Application_Model_M_Doctor::find($id);
            if($doctor){
                $orderid = Application_Model_M_ConsultOrder::getOrderID($this->_auth->userid,$this->_auth->role,$doctor->getId());
                $price   = $doctor->getReservation_fee();
                $payment_status = 0;
                $consultOrder = new Application_Model_O_ConsultOrder();
                $consultOrder
                             ->setOrder_id($orderid)
                             ->setUid($this->_auth->userid)
                             ->setUrole($this->_auth->role)
                             ->setTodid($doctor->getId())
                             ->setTotal_price($price)
                             ->setPayment_status($payment_status)
                             ->setCtime(date('Y-m-d H:i:s'))
                             ;
                try {
                	$out['errno'] = '0';

                	$mer_front_end_url="";
                	$deadtime	= 0;
                	$notify_url	= "http://".$_SERVER['HTTP_HOST']."/consult/notify";
                	$tn = Yy_Upmp_Upmp::getUpmpTn($orderid, $id, $price, $mer_front_end_url, $deadtime,$notify_url);   	
                	$consultOrder->setRemark($tn);
                	$consultOrder->save();
                	$out['tn']  = $tn;
                	
                }catch (Zend_Db_Exception $e){
                	$out['errno'] = '255';
                }
            }else{
            	$out['errno'] = '1';
            }
        	
        }else{
            $out['errno'] = '200';
        }
        $out['msg'] = Yy_ErrMsg_Consult::getMsg('order', $out['errno']);
        Yy_Utils::jsonOut($out);
    	
    }
    
    public function notifyAction(){
    	if (Yy_Upmp_Service::verifySignature($_POST)){// 服务器签名验证成功
    		// 商户的业务逻辑
    		$transStatus = $this->_getParam('transStatus'); // 交易状态
    		 
    		if (""!=$transStatus && "00"==$transStatus){// 交易处理成功
    			$total_fee = $this->_getParam('settleAmount');  // 获取支付总金额
    			$orderid   = $this->_getParam('orderNumber');    // 获取订单号
    			$order	= Application_Model_M_ConsultOrder::fetchByOrderID($orderid);
    			if($order){
    				$total_price	= $order->getTotal_price();
    				if($total_price == $total_fee){
    					$order->setPayment_status(1);
    					$order->save();
    					$did   = $order->getTodid();
    					$doctor    = Application_Model_M_Doctor::find($did);
    					$reservationNumber      = $doctor->getReservation_number() + 1;
    					$doctor->setReservation_number($reservationNumber);
    					$doctor->save();
    					
    				}else{
    					echo "fail";
    				}
    			}else{
    				echo "fail";
    			}
    		}else {
    			echo "fail";
    		}
    		echo "success";
    	}else {// 服务器签名验证失败
    		echo "fail";
    	}    	
    }
    
    public function preconsultAction(){
    	$id	= $this->_getParam('id');
    	if($this->_auth->userid && $this->_auth->role){
    		$doctor	= Application_Model_M_Doctor::find($id);
    		if($doctor && $doctor->getStatus() == 1){
    			$fee	= $doctor->getReservation_fee();
    			if($fee>0){//付费
    			    $bool	= Application_Model_M_ConsultOrder::fetchByUserIdRoleAndDoctorID($this->_auth->userid,$this->_auth->role,$id);//判断是否支付
    			    if($bool){
    			    	$out['errno'] = '0';//已支付
    			    }else{
    			    	$out['errno'] = '201';//需要支付
    			    }
    			}else{//免费
    				$out['errno'] = '0';//跳转到聊天页面
    				$out['id']	= $doctor->getId();
    			}
    		}else{
    			$out['errno'] = '1'; 
    		}
    	}else{
    		$out['errno'] = '200';//跳转到登陆页面
    	}
    	$out['msg'] = Yy_ErrMsg_Consult::getMsg('preconsult', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    /*
     * 发送消息给医生
     */
    public function im2doctorAction(){
    	$id	= $this->_getParam('id');//doctor id
    	$msg = $this->_getParam('msg');
    	if($this->_auth->userid && $this->_auth->role){
    		$doctor	= Application_Model_M_Doctor::find($id);
    		if($doctor && $doctor->getStatus() == 1){
    			//$out['errno'] = '0';
    			$fee = $doctor->getReservation_fee();
    			if($fee>0){
    				$bool	= Application_Model_M_ConsultOrder::fetchByUserIdRoleAndDoctorID($this->_auth->userid,$this->_auth->role,$id);//判断是否支付
    				if(!$bool){	//未支付
    					$out['errno'] = '201';
    					$out['msg'] = Yy_ErrMsg_Consult::getMsg('im', $out['errno']);
    					Yy_Utils::jsonOut($out);
    					return;
    				}
    			}
    			$dailog	= new Application_Model_O_ConsultDialog();
    			$dailog
    					->setFrom_user($this->_auth->userid)
    					->setFrom_role($this->_auth->role)
    					->setTo_user($id)
    					->setTo_role(2)
    					->setMessage($msg)
    					->setCtime(date('Y-m-d H:i:s'))
    					;
    			try {
    			    $out['errno'] = '0';
    			    $dailog->save(); 
    			}catch (Zend_Db_Exception $e){
    			    $out['errno'] = '1';
    			}
    		}else{
    			$out['errno'] = '1';
    		}
    	}else{
    		$out['errno'] = '200';
    	}
    	$out['msg'] = Yy_ErrMsg_Consult::getMsg('im', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    /*
     * 医生回复消息给用户
     */
    public function im2userAction(){
    	$id    = $this->_getParam('id');
    	$role  = $this->_getParam('role');//get from doctorAction
    	$msg   = $this->_getParam('msg');
    	if($this->_auth->userid && $this->_auth->role == 2){
    		if($role == 1){//nuser
    			$imuser  = Application_Model_M_Nuser::find($id);
    		}elseif($role == 2){//doctor
    			$imuser = Application_Model_M_Doctor::find($id);
    		}elseif($role == 3){//hospital
    			$imuser = Application_Model_M_Hospital::find($id);
    		}
    		if($imuser && $imuser->getStatus() == 1){
    		    $dailog	= new Application_Model_O_ConsultDialog();
    		    $dailog
    		           ->setFrom_user($this->_auth->userid)
    		           ->setFrom_role(2)
    		           ->setTo_user($id)
    		           ->setTo_role($role)
    		           ->setMessage($msg)
    		           ->setCtime(date('Y-m-d H:i:s'))
    		           ;
    		    try {
    		    	$out['errno'] = '0';
    		    	$dailog->save();
    		    }catch (Zend_Db_Exception $e){
    		    	$out['errno'] = '1';
    		    }
    		}else{
    			$out['errno'] = '1';
    		}
    	}else{
    		$out['errno'] = '200';
    	}
    	$out['msg'] = Yy_ErrMsg_Consult::getMsg('im2user', $out['errno']);
    	Yy_Utils::jsonOut($out);   	
    }
    /*
     * 医生查看咨询自己的用户
     */
    public function doctorAction(){
        if($this->_auth->userid && $this->_auth->role == 2){
        	//$users = Application_Model_M_ConsultDialog::fetchConsultUsersByDoctorID($this->_auth->userid);
        	$consultorders = Application_Model_M_ConsultOrder::fetchConsultUsersByDoctorID($this->_auth->userid);
        	
        	if(count($consultorders)>0){
        		$out['errno'] = '0';
        		$results = array();
        		
        		foreach ($consultorders as $consultorder){
        			$una   = Yy_Utils::getNameAvatar($consultorder->getUid(),$consultorder->getUrole());
        			$result = array(
        					'id'    => $consultorder->getUid(),
        					'role' => $consultorder->getUrole(),
        					'name' => $una['name'],
        					'avatar'    => $una['avatar'],
        			);
        			array_push($results, $result);
        		}        		
        		
        		
        		$out['users'] = $results;
        	}else{
        		$out['errno'] = '1';
        	}
        }else{
        	$out['errno'] = '200';
        }
        $out['msg'] = Yy_ErrMsg_Consult::getMsg('doctor', $out['errno']);
        Yy_Utils::jsonOut($out);
    }
    /*
     * 用户查看发出过咨询的医生
     */
    public function userAction(){
    	if($this->_auth->userid){
    		//$doctors  = Application_Model_M_ConsultDialog::fetchConsultDoctorsByUserIDRole($this->_auth->userid,$this->_auth->role);
    		$consultorders  = Application_Model_M_ConsultOrder::fetchConsultDoctorsByUserIDRole($this->_auth->userid,$this->_auth->role);
    		if(count($consultorders)>0){
    			$out['errno'] = '0';
    			$results = array();
    			foreach ($consultorders as $consultorder){
    			    $una   = Yy_Utils::getNameAvatar($consultorder->getTodid(),2);
    				$result = array(
    					       'id'    => $consultorder->getTodid(),
    				           'role' => 2,
    				           'name' => $una['name'],
    				           'avatar'    => $una['avatar'],   				        
    				         );
    				array_push($results, $result);
    			}
    			$out['doctors'] = $results;
    		}else{
    			$out['errno'] = '1';
    		}
    	}else{
    		$out['errno'] = '200';
    	}
    	$out['msg'] = Yy_ErrMsg_Consult::getMsg('user', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    /*
     * 用户查看和医生的聊天历史记录
     */
    public function uhistoryAction(){
    	$id    = $this->_getParam('id'); //doctor id
    	if($this->_auth->userid && $this->_auth->role){
    	    $una   = Yy_Utils::getNameAvatar($this->_auth->userid,$this->_auth->role);
    	    $out['uid']  = $this->_auth->userid;
    	    $out['uname'] = $una['name'];
    	    $out['uavatar'] = $una['avatar'];
    	    
    	    $dna   = Yy_Utils::getNameAvatar($id,2);
    	    $out['did'] = $id;
    	    $out['dname'] = $dna['name'];
    	    $out['davatar'] = $dna['avatar'];
    	    
    		$historys = Application_Model_M_ConsultDialog::fetchHistoryByUserIdRoleAndDoctorId($this->_auth->userid,$this->_auth->role,$id);
    		if(count($historys)>0){
    		    $historys = array_reverse($historys);
    			$out['errno'] = '0';
    			$results = array();
    			foreach ($historys as $history){
    				$result = array(
    				       'id'    => $history->getFrom_user(),
    					   'msg'   => $history->getMessage(),
    				       'time'  => $history->getCtime(),
    				       );
    				array_push($results, $result);
    			}
    			$out['historys'] = $results;
    		}else{
    			$out['errno'] = '1';
    		}
    	}else{
    		$out['errno'] = '200';
    	}
    	$out['msg'] = Yy_ErrMsg_Consult::getMsg('uhistory', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    /*
     * 医生查看和用户的聊天历史记录
     */
    public function dhistoryAction(){
    	$id    = $this->_getParam('id'); //userid
    	$role  = $this->_getParam('role'); //get from doctorAction
    	if($this->_auth->userid && $this->_auth->role == 2){
            $una  = Yy_Utils::getNameAvatar($id,$role);
     	    $out['uid']  = $id;
     	    $out['uname'] = $una['name'];
     	    $out['uavatar'] = $una['avatar'];
    	    	
    	    $dna   = Yy_Utils::getNameAvatar($this->_auth->userid,2);
    	    $out['did'] = $this->_auth->userid;
    	    $out['dname'] = $dna['name'];
    	    $out['davatar'] = $dna['avatar'];
    	    
    	    $historys = Application_Model_M_ConsultDialog::fetchHistoryByUserIdRoleAndDoctorId($id,$role,$this->_auth->userid);
    	    if(count($historys)>0){
    	        $historys = array_reverse($historys);
    	    	$out['errno'] = '0';
    	    	$results = array();
    	    	foreach ($historys as $history){
    	    		$result = array(
    	    				'id'    => $history->getFrom_user(),
    	    				'msg'   => $history->getMessage(),
    	    				'time'  => $history->getCtime(),
    	    		);
    	    		array_push($results, $result);
    	    	}
    	    	$out['historys'] = $results;
    	    }else{
    	    	$out['errno'] = '1';
    	    }
    	}else{
    		$out['errno'] = '200';
    	}
    	$out['msg'] = Yy_ErrMsg_Consult::getMsg('dhistory', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
}