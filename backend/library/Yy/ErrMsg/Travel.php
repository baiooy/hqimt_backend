<?php
class Yy_ErrMsg_Travel implements Yy_ErrMsg_Interface{
	public static function getMsg($action,$errno){
	    $msg = '';
	    if(@$_GET['lang'] == 1){
	        //index
	        if($action =='index'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'no travel';
	        			break;
	        	}
	        }
	        //detail
	        if($action =='detail'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'no infomation';
	        			break;
	        	}
	        }
	        //order
	        if($action =='order'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'the travel is offline';
	        			break;
	        		case 200:
	        			$msg = 'no login';
	        			break;
	        		case 255:
	        			$msg = 'order exception';
	        			break;
	        	}
	        }
	    }else{//中文
	        //index
	        if($action =='index'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '有内容';
	        			break;
	        		case 1:
	        			$msg = '暂无信息';
	        			break;
	        	}
	        }
	        //detail
	        if($action =='detail'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '有内容';
	        			break;
	        		case 1:
	        			$msg = '暂无信息';
	        			break;
	        	}
	        }
	        //order
	        if($action =='order'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '成功';
	        			break;
	        		case 1:
	        			$msg = '该医游项目已经下线';
	        			break;
	        		case 200:
	        			$msg = '为登录';
	        			break;
	        		case 255:
	        			$msg = '订单异常';
	        			break;
	        	}
	        }
	    }
	    return $msg;
	}
}