<?php

class Application_Model_M_GlobalConsultation extends Application_Model_M_B_GlobalConsultation{
    public static function fetchByStatus($status = 1){
    	if($status != 1 && $status != 0){
    		return array();
    	}
    	$select = self::select();
    	$select
    	       ->where('status = 1')
    	       ->order('sort asc')
    	       ;
    	$data = self::fetchAll($select);
    	return $data;
    }
    public static function updateImage($id,$img){
    	$sql = "UPDATE yy_global_consultation SET img = '{$img}' WHERE id = {$id}";
    	$config = self::getDb()->getConfig();
    	$pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
    	return $pdo->exec($sql);
    }
    public static function getImage($id){
    	$sql = "SELECT img FROM yy_global_consultation WHERE id={$id}";
    	$res = self::getDb()->query($sql)->fetchAll();
    	$img = "";
    	if(count($res)>0){
    		$img = $res['0']['img'];
    	}
    	return $img;
    }    
    public static function getImgUrl($id){
    	return '/diagnosis/image?id='.$id;
    }

}