<?php

class Application_Model_M_DestinationTravelMap extends Application_Model_M_B_DestinationTravelMap{
    public static function fetchByDestinationID($id){
    	if(!is_numeric($id)){
    		return array();
    	}
    	$select	= self::select();
    	$select
    	->where('destination_id = ?',$id)
    	->where('status = 1')
    	->order('sort asc')
    	;
    	$data	= self::fetchAll($select);
    	return $data;
    }
}