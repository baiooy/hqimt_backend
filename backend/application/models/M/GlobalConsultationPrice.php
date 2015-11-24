<?php

class Application_Model_M_GlobalConsultationPrice extends Application_Model_M_B_GlobalConsultationPrice{
    public static function fetchByStatus($status = 1){
    	if($status != 0 && $status != 1){
    		return array();
    	}
    	$select   = self::select();
    	$select
    	       ->where('status = ?',$status)
    	       ->order('sort asc')
    	       ;
    	$data  = self::fetchAll($select);
    	return $data;
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