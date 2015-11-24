<?php

class Application_Model_M_MemberCard extends Application_Model_M_B_MemberCard{
    public function fetchByStatus($status = 1){
        if($status != 1 && $status !=0){
        	return array();
        }
    	$select = self::select();
    	$select
    	       ->where('status = ?',$status);
    	$data   = self::fetchAll($select);
    	return $data;
    }
    
    
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
    	$cards	= array();
    	if(count($data)>0){
    		foreach ($data as $da){
    			$cardModel	= new Application_Model_O_MemberCard();
    			$cardModel
				    			->setId($da->id)
				    			->setName($da->name)
				    			->setOprice($da->oprice)
				    			->setDprice($da->dprice)
				    			->setPoints($da->points)
				    			->setCtime($da->ctime)
				    			->setUtime($da->utime)
				    			->setStatus($da->status)
				    			;
    			array_push($cards, $cardModel);
    		}
    	}
    	$res	= array(
    			'cards'	=> $cards,
    			'pages'	=> $pages,
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