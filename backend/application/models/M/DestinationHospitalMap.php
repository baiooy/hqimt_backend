<?php

class Application_Model_M_DestinationHospitalMap extends Application_Model_M_B_DestinationHospitalMap{
	public static function fetchByDestinationID($id){
		if(!is_numeric($id)){
			return array();
		}
		$select	= self::select();
		$select
				->where('destination_id = ?',$id)
				//->where('status = 1')
				->order('sort asc')
				;
		$data	= self::fetchAll($select);
		return $data;
	}
	
	public static function delByDidAndHid($did,$hid){
		if(!$did || !$hid){
			return false;
		}
		$where = "destination_id=".$did." AND hospital_id=".$hid;
		$status  = self::delete($where);
		return $status;
	}
	
	public static function fetchByDidAndHid($did,$hid){
		if(!$did || !$hid){
			return array();
		}
		$select = self::select();
		$select
				->where('destination_id = ?',$did)
				->where('hospital_id = ?',$hid)
				;
		$data  = self::fetchAll($select);
		return $data;
	}
	public static function delByDid($id = NULL){
		if(!is_numeric($id)){
			return false;
		}
		$where = "destination_id =".$id;
		$status = self::delete($where);
		return $status;
	}

	public static function delByHid($id = NULL){
		if(!is_numeric($id)){
			return false;
		}
		$where = "hospital_id =".$id;
		$status = self::delete($where);
		return $status;
	}
}