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
    
    public static function getAvatarUrl($id){
    	$url = '/user/image?id='.$id;
    	return $url;
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
}