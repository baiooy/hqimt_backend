<?php

class Application_Model_M_ConsultDialog extends Application_Model_M_B_ConsultDialog{
    public static function fetchHistoryByUserIdRoleAndDoctorId($id,$role,$did){
    	if(!is_numeric($id) || !is_numeric($role) || !is_numeric($did)){
    		return array();
    	}
    	$select    = self::select();
    	$select
    	       ->where('(from_user = ?',$id)
    	       ->where('from_role = ?',$role)
    	       ->where('to_user = ?',$did)
    	       ->where('to_role = 2)')
    	       ->orWhere('(from_user = ?',$did)
    	       ->where('from_role = 2')
    	       ->where('to_user = ?',$id)
    	       ->where('to_role = ?)',$role)
    	       //->where('status = 1')
    	       ->order('id desc')
    	       ->limit(100)
    	       ;
    	$data = self::fetchAll($select);
    	return $data;
    }
    
    /*
     * 查找咨询过该医生的用户
     */
    public static function fetchConsultUsersByDoctorID($did){
    	if(!is_numeric($did)){
    		return array();
    	}
    	$sql = "SELECT DISTINCT from_user,from_role FROM yy_consult_dialog WHERE to_user={$did} AND to_role=2 AND status=1";
    	$data = self::getDb()->query($sql)->fetchAll();
    	$results = array();
    	if(count($data)>0){
    		foreach ($data as $da){
    			$result = array(
    				    'id'    => $da['from_user'],
    			        'role'  => $da['from_role'], 
    			         );
    			$na  = Yy_Utils::getNameAvatar($da['from_user'],$da['from_role']);

     			$result['name'] = $na['name'];
     			$result['avatar'] = $na['avatar'];

    			array_push($results, $result);
    		}
    	}
    	return $results;
    }
    /*
     * 查找该用户发出过咨询的医生
     */
    public static function fetchConsultDoctorsByUserIDRole($id,$role){
    	if(!is_numeric($id) || !is_numeric($role)){
    		return array();
    	}
    	$sql = "SELECT DISTINCT to_user,to_role FROM yy_consult_dialog WHERE from_user={$id} AND from_role={$role} AND to_role=2 AND status=1";
    	$data = self::getDb()->query($sql)->fetchAll();
    	$results = array();
    	if(count($data)>0){
    		foreach ($data as $da){
    			$result = array(
    				'id'    => $da['to_user'],
    			);
    			
    			$na  = Yy_Utils::getNameAvatar($da['to_user'],2);

     			$result['name'] = $na['name'];
     			$result['avatar'] = $na['avatar'];

    		array_push($results, $result);
    		}
    	}
    	return $results;
    }

}