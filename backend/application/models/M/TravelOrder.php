<?php

class Application_Model_M_TravelOrder extends Application_Model_M_B_TravelOrder{
    /*
     * 查找普通用户的travel订单
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
     * 查看医生travel订单
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
     * 查看医院travel订单
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
     * 根据状态查找订单
     */
    public static function fetchByType($type =1,$page = 1,$perpage = 30){
    	$select = self::getDb()->select();
    	$select
    			->from('yy_travel_order','*')
    			->joinLeft('yy_travel', 'yy_travel_order.travel_id=yy_travel.id',array('type'))
    			->where('yy_travel_order.status = 1')
    			->where('yy_travel.type = ?',$type)
    			->order('yy_travel_order.ctime desc')
    			;
    	//echo $select;exit;
    	$adapter = new Zend_Paginator_Adapter_DbSelect($select);
    	$paginator = new Zend_Paginator($adapter);
    	$paginator
		    	->setItemCountPerPage($perpage)
		    	->setCurrentPageNumber($page)
		    	;
    	return $paginator;
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