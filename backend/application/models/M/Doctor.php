<?php

class Application_Model_M_Doctor extends Application_Model_M_B_Doctor{
    /*
     * 通过email和密码查找
     */
    public static function fetchByEmailAndPasswd($email,$passwd){
    	$select = self::select();
    	$select
    	       ->where('email = ?',$email)
    	       ->where('passwd = ?',$passwd)
    	       ->where('status = 1')
    	       ;
    	$data  = self::fetchAll($select);
    	return $data?$data[0]:NULL;
    }
    
    /*
     * 通过邮箱查找
     * @param email
     * @return bool
     */
    public static function fetchByEmail($email){
    	$select = self::select();
    	$select
    	       ->where('email = ?',$email)
    	       ;
    	$data  = self::fetchAll($select);
    	if(count($data)>0){
    		return true;
    	}else{
    		return false;
    	}
    }
    
    /*
     * 咨询医生使用
     */
    public static function fetchByDepartmentHospital($department,$hospital,$sort,$page){
        $select = self::select();
    	if($department){
    		$select
    		      ->where("department like '%{$department}%'")
    		      ->orWhere("special like '%{$department}%'")
    		      ;
    	}
    	if($hospital){
    		$select->where('hospital = ?',$hospital);
    	}
    	if($sort == 1){ //asc
    		$select->order('reservation_number asc');
    	}elseif($sort == 2){ //desc
    	    $select->order('reservation_number desc');
    	}
    	$select->where('status = 1');
    	
    	$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
    	$paginator = new Zend_Paginator($adapter);
    	$paginator
                	->setItemCountPerPage(10)
                	->setCurrentPageNumber($page)
                	;
    	$data = $paginator->getCurrentItems();
    	$pages = $paginator->count();
        
    	$doctors   = array();
    	if(count($data)>0){
    	    foreach ($data as $da){
    	        $doctorModel  = new Application_Model_O_Doctor();
    	        $doctorModel
    	                    ->setId($da->id)
    	                    ->setName($da->name)
    	                    ->setAvatar($da->avatar)
    	                    ->setSex($da->sex)
    	                    ->setBirthday($da->birthday)
    	                    ->setEmail($da->email)
    	                    ->setPasswd($da->passwd)
    	                    ->setDepartment($da->department)
    	                    ->setPoint($da->point)
    	                    ->setCity($da->city)
    	                    ->setCertified($da->certified)
    	                    ->setSpecial($da->special)
    	                    ->setCountry($da->country)
    	                    ->setIntroduction($da->introduction)
    	                    ->setHospital($da->hospital)
    	                    ->setArea($da->area)
    	                    ->setQualification($da->qualification)
    	                    ->setReservation_fee($da->reservation_fee)
    	                    ->setReservation_number($da->reservation_number)
    	                    ->setCtime($da->ctime)
    	                    ->setUtime($da->utime)
    	                    ->setStatus($da->status)
    	                    ;
    	        array_push($doctors, $doctorModel);
    	    }
    	}
    	$res   = array(
    			'doctors' => $doctors,
    			'pages'   => $pages,
    	);
    	return $res;
    }
    
    public function fetchDepartment(){
    	$sql   = "SELECT DISTINCT department FROM yy_doctor where department!='' AND status = 1";
    	$results   = self::getDb()->query($sql)->fetchAll();
    	$data  = array();
    	if(count($results)>0){
    		foreach ($results as $result){
    			array_push($data, $result['department']);
    		}
    	}
    	return $data;
    }
    
    public function fetchHospital(){
    	$sql = "SELECT DISTINCT hospital FROM yy_doctor where hospital != '' AND status = 1";
    	$results = self::getDb()->query($sql)->fetchAll();
    	$data = array();
    	if(count($results)>0){
    		foreach ($results as $result){
    			array_push($data, $result['hospital']);
    		}
    	}
    	return $data;
    }
    
    public static function getCountByDay($page = 1,$perpage = 30){
    	$select	= self::getDb()->select();
    	$select
		    	->from('yy_doctor',array('DATE(ctime) as time','count(*) as count'))
		    	//->where('status = 1')
		    	->group('DATE(ctime)')
		    	->order('id DESC')
		    	;
    	$adapter = new Zend_Paginator_Adapter_DbSelect($select);
    	$paginator = new Zend_Paginator($adapter);
    	$paginator
		    	->setItemCountPerPage($perpage)
		    	->setCurrentPageNumber($page)
		    	;
    	return $paginator;
    }
    
    public static function getCount(){
    	//$sql = "SELECT COUNT(*) as count FROM yy_doctor where status = 1";
    	$sql = "SELECT COUNT(*) as count FROM yy_doctor";
    	$res = self::getDb()->query($sql)->fetchAll();
    	$count = $res[0]['count'];
    	return $count;
    }
    
    /*
     * 根据日期查找
    */
    public static function fetchByDate($date = null,$page = 1,$perpage = 30){
    	$select = self::select();
    	if($date){
    		$stime = $date." 00:00:00";
    		$etime = $date." 23:59:59";
	    	$select
			    	->where('ctime >= ?',$stime)
			    	->where('ctime <= ?',$etime)
			    	;
    	}
    	$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
    	$paginator = new Zend_Paginator($adapter);
    	$paginator
			    	->setItemCountPerPage($perpage)
			    	->setCurrentPageNumber($page)
			    	;
    	return $paginator;
    }
    
    /*
     * 根据状态查找
     */
    public static function fetchByStatus($status = 1,$page =1 ,$perpage = 30){
    	$select = self::select();
    	$select
    			->where('status = ?',$status)
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
    
    
    public static function updateAvatar($id,$avatar){
    	$sql = "UPDATE yy_doctor SET avatar = '{$avatar}' WHERE id = {$id}";
    	$config = self::getDb()->getConfig();
    	$pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
    	return $pdo->exec($sql);
    }
    public static function getAvatar($id){
    	$sql = "SELECT avatar FROM yy_doctor WHERE id={$id}";
    	$res = self::getDb()->query($sql)->fetchAll();
    	$avatar = "";
    	if(count($res)>0){
    		$avatar = $res['0']['avatar'];
    	}
    	return $avatar;
    	 
    }
    
    public static function delById($id = NULL){
    	if(!is_numeric($id)){
    		return false;
    	}
    	$where = "id =".$id;
    	$status = self::delete($where);
    	return $status;
    }
    
    public static function fetchByEmailLike($email){
    	$select = self::select();
    	$select
    	->where("email like '%$email%'")
    	;
    	$data = self::fetchAll($select);
    	return $data;
    }
    
    public static function fetchByNameLike($name){
    	$select = self::select();
    	$select
    	->where("name like '%$name%'")
    	;
    	$data = self::fetchAll($select);
    	return $data;
    }
}