<?php

class Application_Model_M_Departments extends Application_Model_M_B_Departments{
	public static function fetchByCID($cid = null){
		if(!is_numeric($cid)){
			return array();
		}
		$select = self::select();
		$select
				->where('category_id = ?',$cid)
				//->where('status = 1')
				->order('sort asc')
				;
		$data	 = self::fetchAll($select);
		return $data;
	}
	public static function fetchAllPage($page = 1,$perpage = 30){

		$select = self::select();
		$select
				//->where('status = 1')
				->order('sort asc')
				;
		$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
		$paginator = new Zend_Paginator($adapter);
		$paginator
					->setItemCountPerPage($perpage)
					->setCurrentPageNumber($page)
					;
		$data = $paginator->getCurrentItems();
		$pages = $paginator->count();
		$departments	= array();
		if(count($data)>0){
			foreach ($data as $da){
				$departmentModel	= new Application_Model_O_Departments();
				$departmentModel
							->setId($da->id)
							->setName($da->name)
							->setImg($da->img)
							->setCategory_id($da->category_id)
							->setSort($da->sort)
							->setCtime($da->ctime)
							->setUtime($da->utime)
							->setStatus($da->status)
							;
				array_push($departments, $departmentModel);
			}
		}
		$res	= array(
				'departments'	=> $departments,
				'pages'			=> $pages,
		);
		return $res;
	}

	public static function updateImage($id,$img){
		$sql = "UPDATE yy_departments SET img = '{$img}' WHERE id = {$id}";
		$config = self::getDb()->getConfig();
		$pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
		return $pdo->exec($sql);
	}
	public static function getImage($id){
		$sql = "SELECT img FROM yy_departments WHERE id={$id}";
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