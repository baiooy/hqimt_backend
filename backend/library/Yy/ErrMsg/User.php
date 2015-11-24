<?php
class Yy_ErrMsg_User implements Yy_ErrMsg_Interface{
	public static function getMsg($action,$errno){
	    $msg = '';
		if(@$_GET['lang'] == 1){
		    //login
		    if($action =='login'){
		    	switch ($errno){
		    		case 0:
		    			$msg = 'login success';
		    			break;
		    		case 1:
		    			$msg = 'login failed';
		    			break;
		    	}
		    }
		    //register
		    if($action =='register'){
		    	switch ($errno){
		    		case 0:
		    			$msg = 'nregister success';
		    			break;
		    		case 1:
		    			$msg = 'account exists';
		    			break;
		    		case 2:
		    			$msg = 'not email or not mobile';
		    			break;
		    		case 3:
		    			$msg = 'no password';
		    			break;
		    	}
		    }
		    //logout
		    if($action =='logout'){
		    	switch ($errno){
		    		case 0:
		    			$msg = 'logout success';
		    			break;
		    	}
		    }
		    //update
		    if($action =='update'){
		    	switch ($errno){
		    		case 0:
		    			$msg = 'update success';
		    			break;
		    		case 1:
		    			$msg = 'update failed';
		    			break;
		    		case 2:
		    			$msg = 'the mobile number is registered';
		    			break;
		    		case 3:
		    			$msg = 'the email address is registered';
		    			break;
		    		case 200:
		    			$msg = 'no login';
		    			break;
		    	}
		    }
		    //view
		    if($action == 'view'){
		    	switch ($errno){
		    		case 0:
		    			$msg = 'view success';
		    			break;
		    		case 1:
		    			$msg = 'view failed';
		    			break;
		    		case 200:
		    			$msg = 'no login so no view';
		    			break;
		    	}
		    }
		    //order
		    if($action == 'order'){
		    	switch ($errno){
		    		case 0:
		    			$msg = 'success';
		    			break;
		    		case 1:
		    			$msg = 'no order';
		    			break;
		    		case 200:
		    			$msg = 'no login';
		    			break;
		    	}
		    }
		    
		    //point
		    if($action == 'point'){
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
		    	}
		    }
		}else{//中文
		    //login
		    if($action =='login'){
		    	switch ($errno){
		    		case 0:
		    			$msg = '登录成功';
		    			break;
		    		case 1:
		    			$msg = '登录失败';
		    			break;
		    	}
		    }
		    //register
		    if($action =='register'){
		    	switch ($errno){
		    		case 0:
		    			$msg = '注册成功';
		    			break;
		    		case 1:
		    			$msg = '账号已存在';
		    			break;
		    		case 2:
		    			$msg = '账号不是邮箱也不是手机号';
		    			break;
		    		case 3:
		    			$msg = '密码不存在';
		    			break;
		    	}
		    }
		    //logout
		    if($action =='logout'){
		    	switch ($errno){
		    		case 0:
		    			$msg = '退出成功';
		    			break;
		    	}
		    }
		    //update
		    if($action =='update'){
		    	switch ($errno){
		    		case 0:
		    			$msg = '更新成功';
		    			break;
		    		case 1:
		    			$msg = '更新失败';
		    			break;
		    		case 2:
		    			$msg = '将更新的手机号码已经被别人注册';
		    			break;
		    		case 3:
		    			$msg = '将更新的邮箱地址已经被别人注册';
		    			break;
		    		case 200:
		    			$msg = '未登录';
		    			break;
		    	}
		    }
		    //view
		    if($action == 'view'){
		    	switch ($errno){
		    		case 0:
		    			$msg = '查看信息成功';
		    			break;
		    		case 1:
		    			$msg = '查看信息失败';
		    			break;
		    		case 200:
		    			$msg = '未登录不能查看信息';
		    			break;
		    	}
		    }
		    //order
		    if($action == 'order'){
		    	switch ($errno){
		    		case 0:
		    			$msg = '有订单';
		    			break;
		    		case 1:
		    			$msg = '无订单';
		    			break;
		    		case 200:
		    			$msg = '未登录';
		    			break;
		    	}
		    }
		    //point
		    if($action == 'point'){
		    	switch ($errno){
		    		case 0:
		    			$msg = '成功';
		    			break;
		    		case 1:
		    			$msg = '失败';
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