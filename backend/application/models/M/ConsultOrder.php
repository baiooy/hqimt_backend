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
				//->where('status = 1')
				;
		$data = self::fetchAll($select);
		if(count($data)>0){//已支付
			return true;
		}else{//未支付
			return false;
		}
	}
	
	
	public static function fetchAllPage($page = 1,$perpage = 30){
		$select = self::select();
		 
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
				$orderModel	= new Application_Model_O_ConsultOrder();
				$orderModel
							->setId($da->id)
							->setOrder_id($da->order_id)
							->setUid($da->uid)
							->setUrole($da->urole)
							->setTodid($da->todid)
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