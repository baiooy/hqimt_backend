<?php
/*
 * travel
 */
class TravelController extends Zend_Controller_Action
{
    protected $_auth;

    public function init(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->_helper->viewRenderer->setNoRender(true); 
        $this->_helper->layout()->disableLayout();
        $this->_auth = new Zend_Session_Namespace('auth');
    }
    public function indexAction(){
        $type = $this->_getParam('type'); //看病、体检与疗养等
    	$ltype = $this->_getParam('ltype'); //1国内，2国外
    	$sort = $this->_getParam('sort');//1价格从高到低，2价格从低到高，3销量从高到底，4销量从低到高
    	$page = $this->_getParam('page',1);
    	$res  = Application_Model_M_Travel::fetchByType($type,$ltype,$sort,$page);
    	$travels = $res['travels'];
    	$pages   = $res['pages'];
    	if(count($travels)>0){
    		$out['errno'] = '0';
    		if($page < $pages){
    		  $out['page']  = $page;
    		}else{
    			$out['page'] = $pages;
    		}
    		$out['pages'] = $pages;
    		$results = array();
    		foreach ($travels as $travel){
    			$result = array(
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
    			array_push($results, $result);
    		}
    		$out['travels'] = $results;	
    	}else{
    		$out['errno'] = '1';
    	}
    	$out['msg'] = Yy_ErrMsg_Travel::getMsg('index', $out['errno']);
    	Yy_Utils::jsonOut($out);    	
    }
    
    public function detailAction(){
    	$id    = $this->_getParam('id');
    	$type  = $this->_getParam('type');//1特色，2详情，3费用，4注意事项，5行程
    	$additionals = Application_Model_M_TravelAdditional::fetchByTravelID($id,$type);
    	if(count($additionals)>0){
    		$out['errno'] = '0';
    		$details = array();
    		foreach ($additionals as $additional){
    			$detail = array(
    				'title'     => $additional->getTitle(),
    			    'content'   => $additional->getContent(),
    			    'img'       => Application_Model_M_TravelAdditional::getImageUrl($additional->getId()),
    			);
    			array_push($details, $detail);
    		}
    		$out['details']   = $details;
    	}else{
    		$out['errno'] = '1';
    	}
    	$out['msg'] = Yy_ErrMsg_Travel::getMsg('detail', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    public function orderAction(){
        $id = $this->_getParam('id');
        $atnumber   = $this->_getParam('atnumber');
        $ctnumber   = $this->_getParam('ctnumber');
    	if($this->_auth->userid && $this->_auth->role){
    		$travel   = Application_Model_M_Travel::find($id);
    		if($travel){
    			$orderid = Application_Model_M_TravelOrder::getOrderID($this->_auth->userid,$this->_auth->role);
    			$total_price = $travel->getAdult_dprice()*$atnumber+$travel->getChild_dprice()*$ctnumber;
    			$payment_status = 0;
    			$travelOrder  = new Application_Model_O_TravelOrder();
    			$travelOrder
    			            ->setOrder_id($orderid)
    			            ->setUid($this->_auth->userid)
    			            ->setUrole($this->_auth->role)
    			            ->setTravel_id($id)
    			            ->setAdult_ticket_number($atnumber)
    			            ->setChild_ticket_number($ctnumber)
    			            ->setTotal_price($total_price)
    			            ->setPayment_status($payment_status)
    			            ->setCtime(date('Y-m-d H:i:s'))
    			            ;
    			try {
    			    $out['errno'] = '0';
    			    $mer_front_end_url="";
    			    $deadtime	= 0;
    			    $notify_url	= "http://".$_SERVER['HTTP_HOST']."/travel/notify";
    			    $tn = Yy_Upmp_Upmp::getUpmpTn($orderid, $id, $total_price, $mer_front_end_url, $deadtime,$notify_url);
        			$travelOrder->setRemark($tn);
        			$travelOrder->save();
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
    	$out['msg'] = Yy_ErrMsg_Travel::getMsg('order', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    /*
     * 银联回调
     */
    public function notifyAction(){
    	if (Yy_Upmp_Service::verifySignature($_POST)){// 服务器签名验证成功
    		// 商户的业务逻辑
    		$transStatus = $this->_getParam('transStatus'); // 交易状态
    	
    		if (""!=$transStatus && "00"==$transStatus){// 交易处理成功 	 					 
    			$total_fee = $this->_getParam('settleAmount');  // 获取支付总金额
    			$orderid   = $this->_getParam('orderNumber');    // 获取订单号
    			$order	   = Application_Model_M_TravelOrder::fetchByOrderID($orderid);
    			if($order){
    				$total_price	= $order->getTotal_price();
    				if($total_price == $total_fee){
    					$order->setPayment_status(1);
    					$order->save();
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
}