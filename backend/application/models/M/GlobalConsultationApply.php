<?php

class Application_Model_M_GlobalConsultationApply extends Application_Model_M_B_GlobalConsultationApply{
	public static function fetchAllPage($page = 1,$perpage = 30){
	
		$select = self::select();
		$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
		$paginator = new Zend_Paginator($adapter);
		$paginator
					->setItemCountPerPage($perpage)
					->setCurrentPageNumber($page)
					;
		$data = $paginator->getCurrentItems();
		$pages = $paginator->count();
		$applys	= array();
		if(count($data)>0){
			foreach ($data as $da){
				$applyModel	= new Application_Model_O_GlobalConsultationApply();
				$applyModel
							->setId($da->id)
							->setDepartment_category_id($da->department_category_id)
							->setDepartment_id($da->department_id)
							->setEmail($da->email)
							->setMobile($da->mobile)
							->setAge($da->age)
							->setSex($da->sex)
							->setLocation($da->location)
							->setTreatment_time($da->treatment_time)
							->setOpinion($da->opinion)
							->setReport($da->report)		
							->setCtime($da->ctime)
							->setUtime($da->utime)
							->setStatus($da->status)
							;
				array_push($applys, $applyModel);
			}
		}
		$res	= array(
				'applys'	=> $applys,
				'pages'		=> $pages,
		);
		return $res;
	}
	
	public static function updateImage($id,$img){
		$sql = "UPDATE yy_global_consultation_apply SET report = '{$img}' WHERE id = {$id}";
		$config = self::getDb()->getConfig();
		$pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
		return $pdo->exec($sql);
	}
	public static function getImage($id){
		$sql = "SELECT report FROM yy_global_consultation_apply WHERE id={$id}";
		$res = self::getDb()->query($sql)->fetchAll();
		$img = "";
		if(count($res)>0){
			$img = $res['0']['report'];
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