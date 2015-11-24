<?php

class Application_Model_M_DepartmentsCategory extends Application_Model_M_B_DepartmentsCategory{
	public static function fetchByStatus($status = 1){
		if($status != 1 && $status != 0){
			return array();
		}
		$select = self::select();
		$select
				->where('status =1')
				->order('sort desc')
				;
		$data = self::fetchAll($select);
		return $data;
	}

}