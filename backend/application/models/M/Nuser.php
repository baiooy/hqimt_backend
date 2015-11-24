<?php

class Application_Model_M_Nuser extends Application_Model_M_B_Nuser{
    /*
     * 通过email查找
     */
    public static function fetchByEmailAndPasswd($email,$passwd){
    	$select = self::select();
    	$select
    	       ->where('email = ?',$email)
    	       ->where('passwd = ?',$passwd)
    	       ->where('status = 1')
    	       ;
    	$data = self::fetchAll($select);
    	return $data?$data[0]:NULL;
    }
    /*
     * 通过mobile查找
     */
    public static function fetchByMobileAndPasswd($mobile,$passwd){
    	$select = self::select();
    	$select
    	       ->where('mobile = ?',$mobile)
    	       ->where('passwd = ?',$passwd)
    	       ->where('status = 1')
    	       ;
    	$data = self::fetchAll($select);
    	return $data?$data[0]:NULL;
    }
    /*
     * 查询该email是否已经注册
     * @param email
     * @return bool
     */
    public static function fetchByEmail($email){
    	$select = self::select();
    	$select
    	       ->where('email = ?',$email)
    	       ;
    	$data = self::fetchAll($select);
    	
    	if(count($data)>0){
    		return true;
    	}else{
    		return false;
    	}
    }
    /*
     * 查询该mobile是否已经注册
     * @param mobile
     * @return bool
     */
    public static function fetchByMobile($mobile){
    	$select = self::select();
    	$select
    	       ->where('mobile = ?',$mobile)
    	       ;
    	$data = self::fetchAll($select);
    	
    	if(count($data)>0){
    		return true;
    	}else{
    		return false;
    	}
    }
    
    public static function getCountByDay($page = 1,$perpage = 30){
		$select	= self::getDb()->select();
		$select
				->from('yy_nuser',array('DATE(ctime) as time','count(*) as count'))
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
    	//$sql = "SELECT COUNT(*) as count FROM yy_nuser where status = 1";
    	$sql = "SELECT COUNT(*) as count FROM yy_nuser";
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
    
    
    public static function fetchByEmailLike($email){
    	$select = self::select();
    	$select
	    	->where("email like '%$email%'")
	    	;
    	$data = self::fetchAll($select);
    	return $data;
    }
    
    public static function fetchByMobileLike($mobile){
    	$select = self::select();
    	$select
    	->where("mobile like '%$mobile%'")
    	;
    	$data = self::fetchAll($select);
    	return $data;
    }
    
    public static function updateAvatar($id,$avatar){
    	$sql = "UPDATE yy_nuser SET avatar = '{$avatar}' WHERE id = {$id}";
    	$config = self::getDb()->getConfig();
    	$pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
    	return $pdo->exec($sql);
    }
    public static function getAvatar($id){
    	$sql = "SELECT avatar FROM yy_nuser WHERE id={$id}";
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
    
}