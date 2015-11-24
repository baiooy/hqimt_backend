<?php

class Application_Model_M_MemberCard extends Application_Model_M_B_MemberCard{
    public function fetchByStatus($status = 1){
        if($status != 1 && $status !=0){
        	return array();
        }
    	$select = self::select();
    	$select
    	       ->where('status = ?',$status);
    	$data   = self::fetchAll($select);
    	return $data;
    }

}