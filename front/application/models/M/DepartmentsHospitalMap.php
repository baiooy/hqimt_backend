<?php

class Application_Model_M_DepartmentsHospitalMap extends Application_Model_M_B_DepartmentsHospitalMap{
    /*
     * 获得平均价格
     */
	public static function fetchAvgpriceByDID($did){
		if(!is_numeric($did)){
			return 0;
		}
		$select	=self::select();
		$select
				->where('department_id = ?',$did)
				->where('status = 1')
				;
		$data	= self::fetchAll($select);
		if(count($data)>0){
			$priceArr	= array();
			foreach($data as $da){
				$price	= $da->getPrice();
				if($price != 0){
					array_push($priceArr, $price);
				}
			}
			if(count($priceArr)>0){
				$avgprice = ceil(array_sum($priceArr)/count($priceArr));
			}else{
				$avgprice = 0;
			}
			
		}else{
			$avgprice = 0;
		}
		return $avgprice;
	}
	/*
	 * 获取推荐医院
	 */
	public static function fetchByDepartmentID($did){
	    if(!is_numeric($did)){
	    	return array();
	    }
	    $select	= self::select();
	    $select
        	    ->where('department_id = ?',$did)
        	    ->where('status = 1')
        	    ->order('sort asc')
        	    ;
	    $data	= self::fetchAll($select);
	    return $data;
	}

}