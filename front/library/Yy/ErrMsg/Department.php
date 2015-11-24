<?php
class Yy_ErrMsg_Department implements Yy_ErrMsg_Interface{
	public static function getMsg($action,$errno){
	    $msg = '';
	    if(@$_GET['lang'] == 1 || @$_POST['lang'] == 1){
	        if($action =='category' || $action == 'department'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'no';
	        			break;
	        	}
	        }
	    }else{//中文
	        //category
	        if($action =='category' || $action == 'department'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '成功';
	        			break;
	        		case 1:
	        			$msg = '暂无';
	        			break;
	        	}
	        }
	    }
	    return $msg;
	}
}