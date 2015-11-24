<?php

class Application_Model_M_PackageMgt extends Application_Model_M_B_PackageMgt{
	public static function fetchByPlatformPage($os = NULL,$page = 1,$perpage = 30){
		$select = self::select();
		$select->order('version desc');
		if($os){
			$select->where('platform = ?',$os);
		}
		$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
		$paginator = new Zend_Paginator($adapter);
		$paginator
					->setItemCountPerPage($perpage)
					->setCurrentPageNumber($page)
					;
		$data = $paginator->getCurrentItems();
		$pages = $paginator->count();
		$packages	= array();
		if(count($data)>0){
			foreach ($data as $da){
				$packageModel	= new Application_Model_O_PackageMgt();
				$packageModel
								->setId($da->id)
								->setName($da->name)
								->setDescription($da->description)
								->setVersion($da->version)
								->setPlatform($da->platform)
								->setUrl($da->url)
								->setCtime($da->ctime)
								->setUtime($da->utime)
								->setStatus($da->status)
								;
				array_push($packages, $packageModel);
			}
		}
		$res	= array(
				'packages'	=> $packages,
				'pages'		=> $pages,
				);
		return $res;
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