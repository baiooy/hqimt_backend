<?php

class Application_Model_M_TravelAdditional extends Application_Model_M_B_TravelAdditional{
    public static function fetchByTravelID($id = null,$type = null){
    	if(!$id){
    		return array();
    	}
    	if($type != 1 && $type != 2 && $type != 3 && $type !=4 && $type != 5){
    		return array();
    	}
    	$select = self::select();
    	$select
    	       ->where('travel_id = ?',$id)
    	       ->where('type = ?',$type)
    	       ->where('status = 1')
    	       ->order('sort asc')
    	       ;
    	$data = self::fetchAll($select);
    	return $data;
    	       
    }
    
    public static function updateImage($id,$img){
    	$sql = "UPDATE yy_travel_additional SET img = '{$img}' WHERE id = {$id}";
    	$config = self::getDb()->getConfig();
    	$pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
    	return $pdo->exec($sql);
    }
    public static function getImage($id){
    	$sql = "SELECT img FROM yy_travel_additional WHERE id={$id}";
    	$res = self::getDb()->query($sql)->fetchAll();
    	$img = "";
    	if(count($res)>0){
    		$img = $res['0']['img'];
    	}
    	return $img;
    }
    public static function getImageUrl($id){
    	return '/travel/addiimage?id='.$id;
    }

}