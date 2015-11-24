<?php

class Application_Model_M_DepartmentsTravelMap extends Application_Model_M_B_DepartmentsTravelMap{
    public static function fetchByDepartID($id){
    	if(!is_numeric($id)){
    		return array();
    	}
    	$select	= self::select();
    	$select
    	->where('department_id = ?',$id)
    	->where('status = 1')
    	->order('sort asc')
    	;
    	$data	= self::fetchAll($select);
    	return $data;
    }
}