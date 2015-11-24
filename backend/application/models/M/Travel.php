<?php

class Application_Model_M_Travel extends Application_Model_M_B_Travel{
    public static function fetchByType($type = 1,$page = 1,$perpage = 30){
        if($type != 1 && $type != 2 && $type != 3){
        	return array();
        	
        }
    	$select = self::select();
    	$select
    	       ->where('type = ?',$type)
    	       ->where('status =1')
    	       ;
    	//echo $select;exit;
    	$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
    	$paginator = new Zend_Paginator($adapter);
    	$paginator
    	          ->setItemCountPerPage($perpage)
    	          ->setCurrentPageNumber($page)
    	          ;
    	$data = $paginator->getCurrentItems();
    	$pages = $paginator->count();
    	$travels    = array();
        if(count($data)>0){
        	foreach ($data as $da){
        		$travelModel  = new Application_Model_O_Travel();
        		$travelModel
        		            ->setId($da->id)
        		            ->setType($da->type)
        		            ->setLocation_type($da->location_type)
        		            ->setAdult_oprice($da->adult_oprice)
        		            ->setAdult_dprice($da->adult_dprice)
        		            ->setChild_oprice($da->child_oprice)
        		            ->setChild_dprice($da->child_dprice)
        		            ->setArea($da->area)
        		            ->setSales($da->sales)
        		            ->setTitle($da->title)
        		            ->setSubtitle($da->subtitle)
        		            ->setImg($da->img)
        		            ->setCtime($da->ctime)
        		            ->setUtime($da->utime)
        		            ->setStatus($da->status)
        		            ;
        		array_push($travels, $travelModel);
        	}
        }
    	$res   = array(
    		'travels' => $travels,
    	    'pages'   => $pages,
    	);
    	return $res;  	
    }
    
    public static function updateImage($id,$img){
    	$sql = "UPDATE yy_travel SET img = '{$img}' WHERE id = {$id}";
    	$config = self::getDb()->getConfig();
    	$pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
    	return $pdo->exec($sql);
    }
    public static function getImage($id){
    	$sql = "SELECT img FROM yy_travel WHERE id={$id}";
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
    
    
    public static function fetchByAreaPage($area = NULL,$page = 1,$perpage = 30){
    	$select = self::select();
    	$select
		    	->where("area like '%{$area}%'")
		    	->order('ctime asc')
		    	;
    	$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
    	$paginator = new Zend_Paginator($adapter);
    	$paginator
			    	->setItemCountPerPage($perpage)
			    	->setCurrentPageNumber($page)
			    	;
    	return $paginator;
    }
    public static function fetchByTitlePage($title = NULL,$page = 1,$perpage = 30){
    	$select = self::select();
    	$select
		    	->where("title like '%{$title}%'")
		    	->order('ctime asc')
		    	;
    	$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
    	$paginator = new Zend_Paginator($adapter);
    	$paginator
			    	->setItemCountPerPage($perpage)
			    	->setCurrentPageNumber($page)
			    	;
    	return $paginator;
    }
    
    public static function fetchByStatus($status = 1,$page =1 ,$perpage = 30){
    	$select = self::select();
    	if($status != 'all'){
    		$select
		    		->where('status = ?',$status)
		    		;
    	}
    	$select
		    	->order('ctime asc')
		    	;
    	$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
    	$paginator = new Zend_Paginator($adapter);
    	$paginator
			    	->setItemCountPerPage($perpage)
			    	->setCurrentPageNumber($page)
			    	;
    	return $paginator;
    }

}