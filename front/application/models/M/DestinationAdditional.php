<?php

class Application_Model_M_DestinationAdditional extends Application_Model_M_B_DestinationAdditional{
	public static function fetchByDestinationIDAndType($id = null,$type=null){
		if(!$id){
			return array();
		}
		if($type != 1 && $type != 2 && $type != 3){
			return array();
		}
		$select = self::select();
		$select
				->where('destination_id = ?',$id)
				->where('type = ?',$type)
				->where('status = 1')
				->order('sort asc')
				;
		$data = self::fetchAll($select);
		return $data;
	}
	
	public static function updateImage($id,$img){
		$sql = "UPDATE yy_destination_additional SET img = '{$img}' WHERE id = {$id}";
		$config = self::getDb()->getConfig();
		$pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
		return $pdo->exec($sql);
	}
	public static function getImage($id){
		$sql = "SELECT img FROM yy_destination_additional WHERE id={$id}";
		$res = self::getDb()->query($sql)->fetchAll();
		$img = "";
		if(count($res)>0){
			$img = $res['0']['img'];
		}
		return $img;
	}
	
	public static function getImageUrl($id){
		return '/destination/addiimage?id='.$id;
	}

}