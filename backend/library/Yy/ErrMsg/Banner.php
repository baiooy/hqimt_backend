<?php
//1英文，0中文

class Yy_ErrMsg_Banner implements Yy_ErrMsg_Interface{
	public static function getMsg($action,$errno){
	    $msg = '';
	    if(@$_GET['lang'] == 1){
	        if($action =='index'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'no';
	        			break;
	        	}
	        }
	    }else{
	        //index
	        if($action =='index'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '成功';
	        			break;
	        		case 1:
	        			$msg = '暂无广告';
	        			break;
	        	}
	        }
	    }
	    return $msg;
	}
}