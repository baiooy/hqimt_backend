<?php

class Application_Model_M_Hospital extends Application_Model_M_B_Hospital{
    /*
     * 通过邮箱和密码查询
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
     * 通过医院名称查找医院
     */
    public static function fetchByName($name){
    	if(!$name){
    		return array();
    	}
    	
    	$select = self::select();
    	$select
    	       ->where("name like '%{$name}%'")
    	       //->where('status = 1')
    	       ;
    	$data = self::fetchAll($select);
    	return $data;
    }
    
    public static function getCountByDay($page = 1,$perpage = 30){
    	$select	= self::getDb()->select();
    	$select
		    	->from('yy_hospital',array('DATE(ctime) as time','count(*) as count'))
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
    	//$sql = "SELECT COUNT(*) as count FROM yy_hospital where status = 1";
    	$sql = "SELECT COUNT(*) as count FROM yy_hospital";
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
    	if($status !== 'all'){
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
    
    public static function fetchByNamePage($name = NULL,$page = 1,$perpage = 30){
    	$select = self::select();
    	$select
    	       ->where("name like '%{$name}%'")
    	       //->where('status = 1')
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
    	$sql = "UPDATE yy_hospital SET avatar = '{$avatar}' WHERE id = {$id}";
    	$config = self::getDb()->getConfig();
    	$pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
    	return $pdo->exec($sql);
    }
    public static function getAvatar($id){
    	$sql = "SELECT avatar FROM yy_hospital WHERE id={$id}";
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