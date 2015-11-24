<?php

class Application_Model_M_Article extends Application_Model_M_B_Article{
    public static function fetchByType($type = 1){
        if(!is_numeric($type)){
        	return array();
        }
    	$select   = self::select();
    	$select
            	->where('type = ?',$type)
            	//->where('status = 1')
            	->order('sort asc')
            	;
    	$data     = self::fetchAll($select);
    	return $data;
    }
    public static function fetchAllPage($type = 1,$page = 1,$perpage = 30){
    
    	$select = self::select();
    	$select
		    	->where('type = ?',$type)
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
    	$articles	= array();
    	if(count($data)>0){
    		foreach ($data as $da){
    			$articleModel	= new Application_Model_O_Article();
    			$articleModel
				    			->setId($da->id)
				    			->setTitle($da->title)
				    			->setContent($da->content)
				    			->setImg($da->img)
				    			->setSort($da->sort)
				    			->setType($da->type)
				    			->setCtime($da->ctime)
				    			->setUtime($da->utime)
				    			->setStatus($da->status)
				    			;
    			array_push($articles, $articleModel);
    		}
    	}
    	$res	= array(
    			'articles'	=> $articles,
    			'pages'			=> $pages,
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
    
    public static function updateImage($id,$img){
    	$sql = "UPDATE yy_article SET img = '{$img}' WHERE id = {$id}";
    	$config = self::getDb()->getConfig();
    	$pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
    	return $pdo->exec($sql);
    }
    public static function getImage($id){
    	$sql = "SELECT img FROM yy_article WHERE id={$id}";
    	$res = self::getDb()->query($sql)->fetchAll();
    	$img = "";
    	if(count($res)>0){
    		$img = $res['0']['img'];
    	}
    	return $img;
    }

}