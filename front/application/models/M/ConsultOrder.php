<?php

class Application_Model_M_ConsultOrder extends Application_Model_M_B_ConsultOrder{
	public static function fetchByUserIdRoleAndDoctorID($uid,$urole,$did){
		if(!is_numeric($uid)||!is_numeric($urole)|| !is_numeric($did)){
			return false;
		}
		$select	= self::select();
		$select
				->where('uid = ?',$uid)
				->where('urole = ?',$urole)
				->where('todid = ?',$did)
				->where('payment_status = 1')
				->where('status = 1')
				;
		$data = self::fetchAll($select);
		if(count($data)>0){//已支付
			return true;
		}else{//未支付
			return false;
		}
	}
	
	
	/*
	 * 查看普通用户咨询订单
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
	 * 获取订单号
	*/
	public static function getOrderID($uid,$urole,$did){
		$orderid = 'YYz'.time().'z'.$uid.'z'.$urole.'z'.$did;
		return $orderid;
	}
	/*
	 * 获取用户咨询的医生
	 */
	public static function fetchConsultDoctorsByUserIDRole($id,$role){
		$select = self::select();
		$select
		      ->where('uid = ?',$id)
		      ->where('urole = ?',$role)
		      ->where('payment_status = 1')
		      ->where('status = 1')
		      ;
		$data = self::fetchAll($select);
		return $data;
	}
	/*
	 * 获取咨询医生的用户
	 */
	public static function fetchConsultUsersByDoctorID($id){
		$select = self::select();
		$select
		      ->where('todid = ?',$id)
		      ->where('payment_status = 1')
		      ->where('status = 1')
		      ;
		$data  = self::fetchAll($select);
		return $data;
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