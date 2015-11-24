<?php

class Application_Model_M_DepartmentsAdditional extends Application_Model_M_B_DepartmentsAdditional{
	public static function fetchByDepartmentID($id = null){
		 if(!is_numeric($id)){
		 	return array();
		 }

		 $select = self::select();
		 $select
		 		->where('department_id = ?',$id)
		 		//->where('status = 1')
		 		->order('sort asc')
		 		;
		 $data	= self::fetchAll($select);
		 return $data;
	}

	public static function updateImage($id,$img){
		$sql = "UPDATE yy_departments_additional SET img = '{$img}' WHERE id = {$id}";
		$config = self::getDb()->getConfig();
		$pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
		return $pdo->exec($sql);
	}
	public static function getImage($id){
		$sql = "SELECT img FROM yy_departments_additional WHERE id={$id}";
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
	
	public static function delByDid($id = NULL){
		if(!is_numeric($id)){
			return false;
		}
		$where = "department_id =".$id;
		$status = self::delete($where);
		return $status;
	}
}