<?php

class Application_Model_M_DepartmentsCategory extends Application_Model_M_B_DepartmentsCategory{
	public static function fetchByStatus($status = 1){
		if($status != 1 && $status != 0){
			return array();
		}
		$select = self::select();
		$select
				->where('status =1')
				->order('sort desc')
				;
		$data = self::fetchAll($select);
		return $data;
	}
	
	public static function fetchIdAndName(){
		$select	 = self::select();
		$select
				->where('status = 1')
				->order('sort asc')
				;
		$data  = self::fetchAll($select);
		$results  = array();
		if(count($data)>0){
			foreach ($data as $da){
				$result = array(
					'cid'	=> $da->getId(),
					'name'	=> $da->getName(),
				);
				array_push($results, $result);
			}
		}
		return $results;
	}
	
	public static function updateImage($id,$img){
		$sql = "UPDATE yy_departments_category SET img = '{$img}' WHERE id = {$id}";
		$config = self::getDb()->getConfig();
		$pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
		return $pdo->exec($sql);
	}
	public static function getImage($id){
		$sql = "SELECT img FROM yy_departments_category WHERE id={$id}";
		$res = self::getDb()->query($sql)->fetchAll();
		$img = "";
		if(count($res)>0){
			$img = $res['0']['img'];
		}
		return $img;
	}
	
	public static function delById($id = NULL){
		if(!is_numeric($id)){
			return false;
		}
		$where = "id =".$id;
		$status = self::delete($where);
		return $status;
	}

}