<?php

class Application_Model_M_ConsultationDepartments extends Application_Model_M_B_ConsultationDepartments{
    public static function fetchByCID($cid = null){
    	if(!is_numeric($cid)){
    		return array();
    	}
    	$select = self::select();
    	$select
    	->where('category_id = ?',$cid)
    	->where('status = 1')
    	->order('sort asc')
    	;
    	$data	 = self::fetchAll($select);
    	return $data;
    }
}