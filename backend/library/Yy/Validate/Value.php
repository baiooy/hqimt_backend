<?php
class Yy_Validate_Value extends Zend_Validate_Abstract{
	public function isValid($value){
		if($value == ""){
			return false;
		}
		
		if($value == NULL){
			return false;
		}
		return true;
	}
}