<?php

class Application_Model_M_ConsultationDepartments extends Application_Model_M_B_ConsultationDepartments{
	public static function delByCid($cid = NULL){
		if(!is_numeric($cid)){
			return false;
		}
		$where = "category_id =".$cid;
		$status = self::delete($where);
		return $status;
	}
	public static function delById($id = NULL){
		if(!is_numeric($id)){
			return false;
		}
		$where = "id =".$id;
		$status = self::delete($where);
		return $status;
	}
	
	public static function fetchAllPage($page = 1,$perpage = 30){
		$select = self::select();
		$select->order('sort asc');
		//echo $select;exit;
		$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
		$paginator = new Zend_Paginator($adapter);
		$paginator
					->setItemCountPerPage($perpage)
					->setCurrentPageNumber($page)
					;
		$data = $paginator->getCurrentItems();
		$pages = $paginator->count();
		$departs    = array();
		if(count($data)>0){
			foreach ($data as $da){
				$departModel  = new Application_Model_O_ConsultationDepartments();
				$departModel
							->setId($da->id)
							->setName($da->name)
							->setCategory_id($da->category_id)
							->setSort($da->sort)
							->setCtime($da->ctime)
							->setUtime($da->utime)
							->setStatus($da->status)
							;
				array_push($departs, $departModel);
			}
		}
		$res   = array(
				'departs' => $departs,
				'pages'   => $pages,
		);
		return $res;
	}
}