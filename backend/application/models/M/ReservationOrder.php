<?php

class Application_Model_M_ReservationOrder extends Application_Model_M_B_ReservationOrder{
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
     * 查看医生咨询订单
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
     * 查看医院咨询订单
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
}