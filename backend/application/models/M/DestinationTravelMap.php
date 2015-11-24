<?php

class Application_Model_M_DestinationTravelMap extends Application_Model_M_B_DestinationTravelMap{
	public static function fetchByDidAndTid($did,$tid){
		if(!$did || !$tid){
			return array();
		}
		$select = self::select();
		$select
				->where('destination_id = ?',$did)
				->where('travel_id = ?',$tid)
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
	
	public static function delByDidAndTid($did,$hid){
		if(!$did || !$hid){
			return false;
		}
		$where = "destination_id=".$did." AND travel_id=".$hid;
		$status  = self::delete($where);
		return $status;
	}
	
	public static function delByTid($id = NULL){
		if(!is_numeric($id)){
			return false;
		}
		$where = "travel_id =".$id;
		$status = self::delete($where);
		return $status;
	}
}