<?php
class Yy_Validate_Mobile extends Zend_Validate_Abstract{
	public function isValid($value){
	    if(preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/",$value)){
	        return true;
	    }else{
	        return false;
	    }	     
	}
}