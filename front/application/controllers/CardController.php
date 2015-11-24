<?php
/*
 * 会员卡
 */
class CardController extends Zend_Controller_Action
{
    protected $_auth;

    public function init(){
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->_helper->viewRenderer->setNoRender(true); 
        $this->_helper->layout()->disableLayout();
        $this->_auth = new Zend_Session_Namespace('auth');
    }
    /*
     * 查看会员卡
     */
    public function indexAction(){
    	$cards  = Application_Model_M_MemberCard::fetchByStatus(1);
    	if(count($cards)>0){
    		$out['errno'] = '0';
    		$results = array();
    		foreach ($cards as $card){
    			$result = array(
    			        'id'     => $card->getId(),
    				    'name'   => $card->getName(),
    			        'points' => $card->getPoints(),
    			        'oprice' => $card->getOprice(),
    			        'dprice' => $card->getDprice(),
    			         );
    			array_push($results, $result);
    		}
    		$out['cards'] = $results;
    	}else{
    		$out['errno'] = '1';
    	}
    	$out['msg'] = Yy_ErrMsg_Card::getMsg('index', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    /*
     * 会员卡下单
     */
    public function orderAction(){
    	$id    = $this->_getParam('id');
    	if($this->_auth->userid && $this->_auth->role){
    		$card  = Application_Model_M_MemberCard::find($id);
    		if($card){
    		    $orderid = Application_Model_M_MemberCardOrder::getOrderID($this->_auth->userid,$this->_auth->role);
    		    $total_price = $card->getDprice();
    		    $payment_status = 0;
    		    $cardOrder  = new Application_Model_O_MemberCardOrder();
    		    
    		    $cardOrder
    		              ->setOrder_id($orderid)
    		              ->setUid($this->_auth->userid)
    		              ->setUrole($this->_auth->role)
    		              ->setMember_card_id($id)
    		              ->setTotal_price($total_price)
    		              ->setPayment_status($payment_status)
    		              ->setCtime(date('Y-m-d H:i:s'))
    		              ;
    		    try {
    		    	$out['errno'] = '0';

    		    	$mer_front_end_url="";
    		    	$deadtime	= 0;
    		    	$notify_url	= "http://".$_SERVER['HTTP_HOST']."/card/notify";
    		    	$tn = Yy_Upmp_Upmp::getUpmpTn($orderid, $id, $total_price, $mer_front_end_url, $deadtime,$notify_url);   		    	
    		    	$cardOrder->setRemark($tn);
    		    	$cardOrder->save();
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
    	$out['msg'] = Yy_ErrMsg_Card::getMsg('order', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    /*
     * 银联回调,并加积分
     */
    public function notifyAction(){
    	if (Yy_Upmp_Service::verifySignature($_POST)){// 服务器签名验证成功
    		// 商户的业务逻辑
    		$transStatus = $this->_getParam('transStatus'); // 交易状态
    		 
    		if (""!=$transStatus && "00"==$transStatus){// 交易处理成功
    			$total_fee = $this->_getParam('settleAmount');  // 获取支付总金额
    			$orderid   = $this->_getParam('orderNumber');    // 获取订单号
    			$order		= Application_Model_M_MemberCardOrder::fetchByOrderID($orderid);
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
}