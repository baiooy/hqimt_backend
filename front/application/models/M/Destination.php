<?php

class Application_Model_M_Destination extends Application_Model_M_B_Destination{
	public static function fetchByType($type = 1,$page = 1){
		if($type != 1 && $type != 2){
			return array();
		}
		$select = self::select();
		$select
				->where('type = ?',$type)
				->where('status = 1')
				->order('sort asc')
				;
		$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
		$paginator = new Zend_Paginator($adapter);
		$paginator
				->setItemCountPerPage(10)
				->setCurrentPageNumber($page)
				;
		$data = $paginator->getCurrentItems();
		$pages = $paginator->count();
		$destinations	= array();
		if(count($data)>0){
			foreach ($data as $da){
				$destinationModel	= new Application_Model_O_Destination();
				$destinationModel
								->setId($da->id)
								->setCity($da->city)
								->setType($da->type)
								->setLongitude($da->longitude)
								->setLatitude($da->latitude)
								->setImg($da->img)
								->setSort($da->sort)
								->setCtime($da->ctime)
								->setUtime($da->utime)
								->setStatus($da->status)
								;
				array_push($destinations, $destinationModel);
			}
		}
		$res	= array(
				'destinations'	=> $destinations,
				'pages'			=> $pages,
				);
		return $res;
	}
	
	public static function updateImage($id,$img){
		$sql = "UPDATE yy_destination SET img = '{$img}' WHERE id = {$id}";
		$config = self::getDb()->getConfig();
		$pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
		return $pdo->exec($sql);
	}
	public static function getImage($id){
		$sql = "SELECT img FROM yy_destination WHERE id={$id}";
		$res = self::getDb()->query($sql)->fetchAll();
		$img = "";
		if(count($res)>0){
			$img = $res['0']['img'];
		}
		return $img;
	}
	public static function getImageUrl($id){
		return '/destination/image?id='.$id;
	}

}