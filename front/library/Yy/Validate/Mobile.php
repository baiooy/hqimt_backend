<?php
class Yy_Validate_Mobile extends Zend_Validate_Abstract{
	public function isValid($value){
		if(is_numeric($value) && strlen($value) == 11){
			return true;
		}else{
			return false;
		}
	}
}