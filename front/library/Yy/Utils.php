<?php
class Yy_Utils{
	public static function jsonOut($out){
	   if(@$_GET['debug'] == 1){
	       $dbAdapter      = Zend_Db_Table::getDefaultAdapter();
	       $profiler       = $dbAdapter->getProfiler();
	       $queriesCount   = $profiler->getTotalNumQueries();
	       if($queriesCount>0){
    	       $queries                = $profiler->getQueryProfiles();
    	       $queryTotalElapsedSecs  = $profiler->getTotalElapsedSecs();
    	       $out['dbQueriesCount']          = $queriesCount;
    	       $queriesDetail = array();
    	       foreach($queries as $query){
    	       	$queryDetail = array(
    	       			'query' => $query->getQuery(),
    	       			'second'        => $query->getElapsedSecs(),
    	       	);
    	       	array_push($queriesDetail, $queryDetail);
    	       }
    	       $out['dbQueriesDetail'] = $queriesDetail;
    	       
    	       $out['dbQueriesTimeCount']      = $queryTotalElapsedSecs;	  
	       }     
	   }
	   $out = self::arrFormat($out);
	   echo Zend_Json::encode($out);
	}
	
	protected static function arrFormat($arr){
		if(is_array($arr)){
			foreach ($arr as $k=>$v){
				$arr[$k] = self::arrFormat($arr[$k]);
			}
		}else{
			$arr = (string) $arr;
		}
		return $arr;
	}
	
	/*
	 * 获取姓名和头像
	 */
	public static function getNameAvatar($id = null,$role = null){
// 	    if(!is_numeric($id) || !is_numeric($role)){
// 	    	return array(
// 	    		'name'   => '',
// 	    	    'avatar' => '',
// 	    	);
// 	    }
	    if($role == 1){
	    	$user = Application_Model_M_Nuser::find($id);
	    	$avatarurl = Application_Model_M_Nuser::getAvatarUrl($id);
	    }elseif($role == 2){
	    	$user = Application_Model_M_Doctor::find($id);
	    	$avatarurl = Application_Model_M_Doctor::getAvatarUrl($id);
	    }elseif($role == 3){
	    	$user = Application_Model_M_Hospital::find($id);
	    	$avatarurl = Application_Model_M_Hospital::getAvatarUrl($id);
	    }else{
	       $user = NULL;
	    }
	    if($user){
	    	$res = array(
	    		'name'   => $user->getName(),
	    	    'avatar' => $avatarurl,
	    	    );
	    }else{
	    	$res = array(
	    		'name'   => '',
	    	    'avatar' => '',
	    	    );
	    }
	    return $res;
	}
	
	public static function getWriteDir(){
		$os = PHP_OS;
		$ds = DIRECTORY_SEPARATOR;
		if($os == 'WINNT'){
			$str = 'C:'.$ds.'Windows'.$ds.'Temp'.$ds;
		}else{
			$str = $ds.'tmp'.$ds;
		}
		return $str;
	}
}