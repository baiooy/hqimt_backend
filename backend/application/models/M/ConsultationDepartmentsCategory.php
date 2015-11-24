<?php

class Application_Model_M_ConsultationDepartmentsCategory extends Application_Model_M_B_ConsultationDepartmentsCategory{	
	public static function delById($id = NULL){
		if(!is_numeric($id)){
			return false;
		}
		$where = "id =".$id;
		$status = self::delete($where);
		return $status;
	}
	
	public static function fetchIdAndName(){
		$select	 = self::select();
		$select
				->where('status = 1')
				->order('sort asc')
				;
		$data  = self::fetchAll($select);
		$results  = array();
		if(count($data)>0){
			foreach ($data as $da){
				$result = array(
						'cid'	=> $da->getId(),
						'name'	=> $da->getName(),
				);
				array_push($results, $result);
			}
		}
		return $results;
	}
}