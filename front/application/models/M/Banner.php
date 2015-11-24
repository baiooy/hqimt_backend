<?php

class Application_Model_M_Banner extends Application_Model_M_B_Banner{
    public static function fetchByStatus($status = 1){
    	$select = self::select();
    	$select
    	->where('status = ?',$status)
    	->order('sort asc')
    	;
    	$data  = self::fetchAll($select);
    	return $data;
    }
    
    public function getImage($id){
    	$sql = "SELECT img FROM yy_banner WHERE id={$id}";
    	$res = self::getDb()->query($sql)->fetchAll();
    	$img = "";
    	if(count($res)>0){
    		$img = $res['0']['img'];
    	}
    	return $img;
    }
}