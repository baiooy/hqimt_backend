<?php

class Application_Model_M_Departments extends Application_Model_M_B_Departments{
	public static function fetchByCID($cid = null){
		if(!is_numeric($cid)){
			return array();
		}
		$select = self::select();
		$select
				->where('category_id = ?',$cid)
				->where('status = 1')
				->order('sort asc')
				;
		$data	 = self::fetchAll($select);
		return $data;
	}
	
// 	public static function fetchPriceByCID($cid = null){
// 		if(!is_numeric($cid)){
// 			return array();
// 		}
// 		$select	=self::select();
// 		$select
// 				->join('yy_departments_hospital_map', 'yy_departments.id = yy_departments_hospital_map.department_id',array())
// 				->where('yy_departments.category_id = ?',$cid)
// 				->where('yy_departments.status = 1')
// 				->where('yy_departments_hospital_map.status = 1')
// 				;
// 				echo $select->__toString();exit;
// 	}

	public static function fetchByStatus($status = 1,$page = 1,$perpage = 30){
	
		$select = self::select();
		$select
        		->where('status = ?',$status)
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
	
	public static function getImageUrl($id){
		$url = '/costperf/image?id='.$id;
		return $url;
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

}