<?php
class Yy_ErrMsg_Diagnosis implements Yy_ErrMsg_Interface{
	public static function getMsg($action,$errno){
	    $msg = '';
	    if(@$_GET['lang'] == 1 || @$_POST['lang'] == 1){
	        if($action =='index' || $action == 'price'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'no';
	        			break;
	        	}
	        }
	        //apply
	        if($action =='apply'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'upload success';
	        			break;
	        		case 1:
	        			$msg = 'upload failed';
	        			break;
	        	}
	        }
	    }else{//中文
	        //index
	        if($action =='index' || $action == 'price'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '成功';
	        			break;
	        		case 1:
	        			$msg = '暂无';
	        			break;
	        	}
	        }
	        //apply
	        if($action =='apply'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '上传成功';
	        			break;
	        		case 1:
	        			$msg = '上传失败';
	        			break;
	        	}
	        }
	    }
	    return $msg;
	}
}