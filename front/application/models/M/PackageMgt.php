<?php

class Application_Model_M_PackageMgt extends Application_Model_M_B_PackageMgt{
    public static function fetchByPlatform($os = NULL){
    	if(!$os){
    		return NULL;
    	}
    	$select = self::select();
    	$select
    	       ->where('platform = ?',$os)
    	       ->where('status = 1')
    	       ->order('version desc')
    	       ->limit(1)
    	       ;
    	$data = self::fetchAll($select);
    	if(count($data)>0){
    		return $data[0];
    	}else{
    		return NULL;
    	}
    }
}