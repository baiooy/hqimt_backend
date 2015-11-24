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
    	       ->where('status = 1')
    	       ;
    	$data = self::fetchAll($select);
    	return $data;
    }
    
    public static function getAvatarUrl($id){
    	$url = '/hospital/image?id='.$id;
    	return $url;
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
}