<?php

class Application_Model_M_Admin extends Application_Model_M_B_Admin{
	public static function fetchByAccountAndPasswd($account,$passwd){
		if(!$account && !$passwd){
			return false;
		}
		$select = self::select();
		$select
				->where('account = ?',$account)
				->where('passwd = ?',$passwd)
				->where('status = 1')
				;
		$data = self::fetchAll($select);
		if(count($data)>0){
			return $data[0];
		}else{
			return false;
		}
	}
	
	public static function changePasswdByAccount($account,$passwd){
		if(!$account && !$passwd){
			return false;
		}
		$data = array(
			'passwd'	=> md5($passwd),
		);
		$where = array('account = ?' => $account);
		$rows = self::getDbTable()->update($data, $where);	
		if($rows == 1){
			return true;
		}else{
			return false;
		}
	}

}