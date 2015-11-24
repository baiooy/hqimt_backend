<?php
//1英文，0中文
class Yy_ErrMsg_Card implements Yy_ErrMsg_Interface{
	public static function getMsg($action,$errno){
	    $msg = '';
	    if(@$_GET['lang'] == 1){
	        if($action =='index'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'no member card';
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
	        			$msg = 'the member card is offline';
	        			break;
	        		case 200:
	        			$msg = 'no login';
	        			break;
	        		case 255:
	        			$msg = 'order exception';
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
	        			$msg = '暂无会员卡';
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
	        			$msg = '该会员卡已经下线';
	        			break;
	        		case 200:
	        			$msg = '未登录';
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