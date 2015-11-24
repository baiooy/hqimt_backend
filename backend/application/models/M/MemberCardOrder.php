<?php

class Application_Model_M_MemberCardOrder extends Application_Model_M_B_MemberCardOrder{
    /*
     * 查看普通用户购买积分订单
     */
    public static function fetchByNuser($nid){
    	$select = self::select();
    	$select
    	       ->where('uid = ?',$nid)
    	       ->where('urole = 1')
    	       ->where('status = 1')
    	       ;
    	$data = self::fetchAll($select);
    	return $data;
    }
    
    /*
     * 查看医生购买积分订单
    */
    public static function fetchByDoctor($did){
    	$select = self::select();
    	$select
    	->where('uid = ?',$did)
    	->where('urole = 2')
    	->where('status = 1')
    	;
    	$data = self::fetchAll($select);
    	return $data;
    }
    
    /*
     * 查看医生购买积分订单
    */
    public static function fetchByHospital($hid){
    	$select = self::select();
    	$select
    	->where('uid = ?',$hid)
    	->where('urole = 3')
    	->where('status = 1')
    	;
    	$data = self::fetchAll($select);
    	return $data;
    }
    
    
    
    public static function fetchAllPage($role,$page = 1,$perpage = 30){
    	if($role != 0 && $role != 1 && $role != 2 && $role !=3){
    		return array();
    	}
    	$select = self::select();
		
    	if($role != 0){
    		$select
    				->where('urole = ?',$role)
    				->order('ctime desc')
    				;
    	}
    	
    	$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
    	$paginator = new Zend_Paginator($adapter);
    	$paginator
			    	->setItemCountPerPage($perpage)
			    	->setCurrentPageNumber($page)
			    	;
    	$data = $paginator->getCurrentItems();
    	$pages = $paginator->count();
    	$orders	= array();
    	if(count($data)>0){
    		foreach ($data as $da){
    			$orderModel	= new Application_Model_O_MemberCardOrder();
    			$orderModel
			    			->setId($da->id)
			    			->setOrder_id($da->order_id)
			    			->setUid($da->uid)
			    			->setUrole($da->urole)
			    			->setMember_card_id($da->member_card_id)
			    			->setTotal_price($da->total_price)
			    			->setPayment_status($da->payment_status)
			    			->setRemark($da->remark)
			    			->setCtime($da->ctime)
			    			->setUtime($da->utime)
			    			->setStatus($da->status)
			    			;
    			array_push($orders, $orderModel);
    		}
    	}
    	$res	= array(
    			'orders'	=> $orders,
    			'pages'		=> $pages,
    	);
    	return $res;
    }
    
    public static function delById($id = NULL){
    	if(!is_numeric($id)){
    		return false;
    	}
    	$where = "id =".$id;
    	$status = self::delete($where);
    	return $status;
    }

}