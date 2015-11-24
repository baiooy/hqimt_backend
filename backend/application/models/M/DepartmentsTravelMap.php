<?php

class Application_Model_M_DepartmentsTravelMap extends Application_Model_M_B_DepartmentsTravelMap{
	public static function delByTid($id = NULL){
		if(!is_numeric($id)){
			return false;
		}
		$where = "travel_id =".$id;
		$status = self::delete($where);
		return $status;
	}
	public static function delByDid($id = NULL){
		if(!is_numeric($id)){
			return false;
		}
		$where = "department_id =".$id;
		$status = self::delete($where);
		return $status;
	}
	
	public static function fetchByDidAndTid($did,$tid){
		if(!$did || !$tid){
			return array();
		}
		$select = self::select();
		$select
				->where('department_id = ?',$did)
				->where('travel_id = ?',$tid)
				;
		$data  = self::fetchAll($select);
		return $data;
	}
	
	public static function fetchByDepartID($id){
		if(!is_numeric($id)){
			return array();
		}
		$select	= self::select();
		$select
				->where('department_id = ?',$id)
				->order('sort asc')
				;
		$data	= self::fetchAll($select);
		return $data;
	}
	
	public static function delByDidAndTid($did,$hid){
		if(!$did || !$hid){
			return false;
		}
		$where = "department_id=".$did." AND travel_id=".$hid;
		$status  = self::delete($where);
		return $status;
	}
}