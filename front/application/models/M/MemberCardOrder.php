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
    
    /*
     * 获取订单号
    */
    public static function getOrderID($uid,$urole){
    	$orderid = 'YYz'.time().'z'.$uid.'z'.$urole;
    	return $orderid;
    }
    
    /*
     * 银联回调使用
    */
    public static function fetchByOrderID($orderid){
    	$select	= self::select();
    	$select
		    	->where('order_id =?',$orderid)
		    	->where('status = 1')
		    	;
    	$data	= self::fetchAll($select);
    	if(count($data) == 1){
    		return $data[0];
    	}else{
    		return NULL;
    	}
    }

}