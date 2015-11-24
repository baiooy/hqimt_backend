<?php
//1英文，0中文
class Yy_ErrMsg_Consult implements Yy_ErrMsg_Interface{
	public static function getMsg($action,$errno){
	    $msg = '';
	    if(@$_GET['lang'] == 1 || @$_POST['lang'] == 1){
	        if($action =='index'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'no doctor';
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
	        			$msg = 'no doctor';
	        			break;
	        		case 200:
	        			$msg = 'no login';
	        			break;
	        		case 255:
	        			$msg = 'order exception';
	        			break;
	        	}
	        }
	        //preconsult
	        if($action =='preconsult'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'no';
	        			break;
	        		case 200:
	        			$msg = 'no login';
	        			break;
	        		case 201:
	        			$msg = 'no order';
	        			break;
	        	}
	        }
	        //im2doctor
	        if($action == 'im2doctor' || $action == 'im2user'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'failed';
	        			break;
	        		case 200:
	        			$msg = 'no login';
	        			break;
	        		case 201:
	        			$msg = 'no order';
	        			break;
	        	}
	        }
	        //doctor
	        if($action == 'doctor'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'no user consult you now';
	        			break;
	        		case 200:
	        			$msg = 'no login';
	        			break;
	        	}
	        }
	        //user
	        if($action == 'user'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'you do not consult doctor';
	        			break;
	        		case 200:
	        			$msg = 'no login';
	        			break;
	        	}
	        }
	        //history
	        if($action == 'uhistory' || $action == 'dhistory'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'no history message';
	        			break;
	        		case 200:
	        			$msg = 'no login';
	        			break;
	        	}
	        }
	    }else{//中文
	        //index
	        if($action =='index'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '成功';
	        			break;
	        		case 1:
	        			$msg = '暂无';
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
	        			$msg = '该医生不存在';
	        			break;
	        		case 200:
	        			$msg = '未登录';
	        			break;
	        		case 255:
	        			$msg = '订单异常';
	        			break;
	        	}
	        }
	         
	        //preconsult
	        if($action =='preconsult'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '成功';
	        			break;
	        		case 1:
	        			$msg = '暂无';
	        			break;
	        		case 200:
	        			$msg = '未登录';
	        			break;
	        		case 201:
	        			$msg = '未支付';
	        			break;
	        	}
	        }
	        //im2doctor
	        if($action == 'im2doctor' || $action == 'im2user'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '发送成功';
	        			break;
	        		case 1:
	        			$msg = '发送失败';
	        			break;
	        		case 200:
	        			$msg = '未登录';
	        			break;
	        		case 201:
	        			$msg = '未支付';
	        			break;
	        	}
	        }
	        //doctor
	        if($action == 'doctor'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '有咨询用户';
	        			break;
	        		case 1:
	        			$msg = '暂时没有咨询您的用户';
	        			break;
	        		case 200:
	        			$msg = '未登录';
	        			break;
	        	}
	        }
	        //user
	        if($action == 'user'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '有咨询医生';
	        			break;
	        		case 1:
	        			$msg = '暂时没有咨询过医生';
	        			break;
	        		case 200:
	        			$msg = '未登录';
	        			break;
	        	}
	        }
	        //history
	        if($action == 'uhistory' || $action == 'dhistory'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '有历史消息';
	        			break;
	        		case 1:
	        			$msg = '暂无历史消息';
	        			break;
	        		case 200:
	        			$msg = '未登录';
	        			break;
	        	}
	        }
	    }
	    return $msg;
	}
}