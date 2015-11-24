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
	    }elseif($role == 2){
	    	$user = Application_Model_M_Doctor::find($id);
	    }elseif($role == 3){
	    	$user = Application_Model_M_Hospital::find($id);
	    }else{
	       $user = NULL;
	    }
	    if($user){
	    	$res = array(
	    		'name'   => $user->getName(),
	    	    'avatar' => $user->getAvatar(),
	    	    );
	    }else{
	    	$res = array(
	    		'name'   => '',
	    	    'avatar' => '',
	    	    );
	    }
	    return $res;
	}
	
	
	public static function getSex($sex){
		$str = "未设置";
		if($sex == 1){
			$str = "男";
		}elseif($sex == 2){
			$str = "女";
		}
		return $str;
	}
	public static function getTravelType($type){
		//1体检与疗养，2看病，3美容与抗衰老
		$str = "";
		if($type == 1){
			$str = "体检与疗养";
		}elseif($type == 2){
			$str = "看病";
		}elseif($type == 3){
			$str = "美容与抗衰老";
		}
		return $str;
	}
	public static function getTravelLType($ltype){
		$str = "";
		if($ltype == 1){
			$str = "国内";
		}elseif ($ltype == 2){
			$str = "国外";
		}
		return $str;
	}
	public static function getUserRole($role){
		$str = "";
		if($role == 1){
			$str ="普通用户";
		}elseif($role == 2){
			$str = "医生";
		}elseif($role == 3){
			$str = "医院";
		}
		return $str;
	}
	
	public static function getAccount($id,$role){
		//role:1普通用户，2医生用户，3医院用户
		$account = "";
		if($role == 1){
			$nuser = Application_Model_M_Nuser::find($id);
			if($nuser){
				$account = $nuser->getMobile();
				if(!$account){
					$account = $nuser->getEmail();
				}
			}
		}elseif($role == 2){
			$doctor = Application_Model_M_Doctor::find($id);
			if($doctor){
				$account = $doctor->getEmail();
			}
		}elseif($role == 3){
			$hospital = Application_Model_M_Hospital::find($id);
			if($hospital){
				$account = $hospital->getEmail();
			}
		}
		return $account;
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
	
	public static function getTravelAddiType($type){
		//1特色，2详情，3费用，4注意事项，5行程
		$str = ""; 
		switch ($type){
			case 1:
				$str = "特色";
				break;
			case 2:
				$str  = "详情";
				break;
			case 3:
				$str = "费用";
				break;
			case 4:
				$str  = "注意事项";
				break;
			case 5:
				$str ="行程";
				break;
		}
		return $str;
	}
	
	public static function getConsultByType($type){
		//1个人服务，2企业服务，3第二医学诊断意见
		$str = "";
		switch($type){
			case 1:
				$str = "个人服务";
				break;
			case 2:
				$str = "企业服务";
				break;
			case 3:
				$str = "第二医学意见";
				break;
		}
		return $str;
	}
	
	public static function getDestinationAddType($type){
		$str = "";
		switch ($type){
			case 1:
				$str = "医疗概况";
				break;
			case 2:
				$str = "特色景点";
				break;
		}
		return $str;
	}
	
	public static function getDepartmentAddType($type){ //1项目介绍，2成功案例
		$str = "";
		switch ($type){
			case 1:
				$str = "项目介绍";
				break;
			case 2:
				$str = "成功案例";
				break;
		}
		return $str;
	}
	
	public static function getMapByDidAndHid($did,$hid){
		$data = Application_Model_M_DestinationHospitalMap::fetchByDidAndHid($did,$hid);
		if(count($data)>0){
			return true;
		}else{
			return false;
		}
	}
	
	public static function getMapByDidAndTid($did,$tid){
		$data = Application_Model_M_DestinationTravelMap::fetchByDidAndTid($did,$tid);
		if(count($data)>0){
			return true;
		}else{
			return false;
		}
	}
	public static function getMapByDepartIdAndTid($did,$tid){
		$data	= Application_Model_M_DepartmentsTravelMap::fetchByDidAndTid($did,$tid);
		if(count($data)>0){
			return true;
		}else{
			return false;
		}
	}
	
	public static function getMapByDepartIdAndHid($did,$hid){
		$data = Application_Model_M_DepartmentsHospitalMap::fetchByDidAndHid($did,$hid);
		if(count($data)>0){
			return true;
		}else{
			return false;
		}		
	}
	
	public static function getCategoryNameByCID($cid){
		$departcate	= Application_Model_M_DepartmentsCategory::find($cid);
		$str = "";
		if($departcate){
			$str = $departcate->getName();
		}
		return $str;
	}
	
	public static function getDepartNameByDID($did){
		$depart	= Application_Model_M_Departments::find($did);
		$str = "";
		if($depart){
			$str = $depart->getName();
		}
		return $str;
	}
	
	public static function getAllCategory(){
		$cates	= Application_Model_M_DepartmentsCategory::fetchIdAndName();
		return $cates;
	}
	public static function getAllConsultationCategory(){
		$cates = Application_Model_M_ConsultationDepartmentsCategory::fetchIdAndName();
		return $cates;
	}
	
	public static function getCardNameById($cardid){
		$str = "";
		$card = Application_Model_M_MemberCard::find($cardid);
		if($card){
			$str = $card->getName();
		}
		return $str;
	}
	public static function getConsultationDepartmentsCategoryNameByCID($cid){
		$str = "";
		$cdcate	= Application_Model_M_ConsultationDepartmentsCategory::find($cid);
		if($cdcate){
			$str = $cdcate->getName();
		}
		return $str;
		
	}
	public static function getConsultationDepartmentNameByDID($did){
		$str = "";
		$depart = Application_Model_M_ConsultationDepartments::find($did);
		if($depart){
			$str = $depart->getName();
		}
		return $str;
	}
	
// 	public static function getConsultationCategoryNameByCID($cid){
// 		$str = "";
// 		$departcate	= Application_Model_M_ConsultationDepartmentsCategory::find($cid);
// 		if($departcate){
// 			$str = $departcate->getName();
// 		}
// 		return $str;
// 	}
	
	public static function getArticleByType($type){
		$str = "";
		switch ($type){
			case 1:
				$str = "帮助文本";
				break;
			case 2:
				$str = "法律文本";
				break;
			case 3:
				$str = "关于我们文本";
				break;	
			case 4:
				$str = "虹桥中心电话";
				break;			
		}
		return $str;
	}
	
	public static function RDelByDestinationID($did){
		Application_Model_M_Destination::delById($did);
		Application_Model_M_DestinationAdditional::delByDid($did);
		Application_Model_M_DestinationHospitalMap::delByDid($did);
		Application_Model_M_DestinationTravelMap::delByDid($did);
	}
	
	public static function RDelByDepartmentID($did){
		Application_Model_M_Departments::delById($did);
		Application_Model_M_DepartmentsAdditional::delByDid($did);
		Application_Model_M_DepartmentsHospitalMap::delByDid($did);
		Application_Model_M_DepartmentsTravelMap::delByDid($did);
	}
	public static function RDelByHospitalID($hid){
		Application_Model_M_Hospital::delById($hid);
		Application_Model_M_DestinationHospitalMap::delByHid($hid);
		Application_Model_M_DepartmentsHospitalMap::delByHid($hid);
	}
	
	public static function RDelByTravelID($tid){
		Application_Model_M_Travel::delById($tid);
		Application_Model_M_TravelAdditional::delByTid($tid);
		Application_Model_M_DepartmentsTravelMap::delByTid($tid);
		Application_Model_M_DestinationTravelMap::delByTid($tid);		
	}
	public static function getCertifiedStar($num){
		$str = "";
		switch ($num){
			case 1:
				$str = "★";
				break;
			case 2:
				$str = "★★";
				break;
			case 3:
				$str = "★★★";
				break;
			case 4:
				$str = "★★★★";
				break;
			case 5:
				$str = "★★★★★";
				break;
		}
		return $str;
	}
	
	public static function getTravelTypeByTravelID($id){
		$travel	= Application_Model_M_Travel::find($id);
		$type   = $travel->getType();
		return $type;
	}
}