<?php

class Application_Model_M_Feedback extends Application_Model_M_B_Feedback{
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
		$feedbacks	= array();
		if(count($data)>0){
			foreach ($data as $da){
				$feedbackModel	= new Application_Model_O_Feedback();
				$feedbackModel
								->setId($da->id)
								->setContent($da->content)
								->setContact($da->contact)
								->setCtime($da->ctime)
								->setUtime($da->utime)
								->setStatus($da->status)
								;
				array_push($feedbacks, $feedbackModel);
			}
		}
		$res	= array(
				'feedbacks'	=> $feedbacks,
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