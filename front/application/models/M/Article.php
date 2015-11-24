<?php

class Application_Model_M_Article extends Application_Model_M_B_Article{
    public static function fetchByType($type = 1){
        if(!is_numeric($type)){
        	return array();
        }
    	$select   = self::select();
    	$select
            	->where('type = ?',$type)
            	->where('status = 1')
            	->order('sort asc')
            	;
    	$data     = self::fetchAll($select);
    	return $data;
    }
    
    public static function updateImage($id,$img){
    	$sql = "UPDATE yy_article SET img = '{$img}' WHERE id = {$id}";
    	$config = self::getDb()->getConfig();
    	$pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
    	return $pdo->exec($sql);
    }
    public static function getImage($id){
    	$sql = "SELECT img FROM yy_article WHERE id={$id}";
    	$res = self::getDb()->query($sql)->fetchAll();
    	$img = "";
    	if(count($res)>0){
    		$img = $res['0']['img'];
    	}
    	return $img;
    }
    
    public static function getImageUrl($id){
    	return '/more/artimage?id='.$id;
    }

}