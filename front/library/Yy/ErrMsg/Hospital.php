<?php
class Yy_ErrMsg_Hospital implements Yy_ErrMsg_Interface{
    public static function getMsg($action,$errno){
    	$msg = '';
    	if(@$_GET['lang'] == 1 || @$_POST['lang'] == 1){
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
    	    //logout
    	    if($action =='logout'){
    	    	switch ($errno){
    	    		case 0:
    	    			$msg = 'logout success';
    	    			break;
    	    	}
    	    }
    	    //register
    	    if($action =='register'){
    	    	switch ($errno){
    	    		case 0:
    	    			$msg = 'dregister success';
    	    			break;
    	    		case 1:
    	    			$msg = 'email exists';
    	    			break;
    	    		case 2:
    	    			$msg = 'account not email';
    	    			break;
    	    		case 3:
    	    			$msg = 'no passwd';
    	    			break;
    	    	}
    	    }
    	    
    	    //update
    	    if($action =='update'){
    	    	switch ($errno){
    	    		case 0:
    	    			$msg = 'dupdate success';
    	    			break;
    	    		case 1:
    	    			$msg = 'dupdate failed';
    	    			break;
    	    		case 200:
    	    			$msg = 'no login';
    	    			break;
    	    	}
    	    }
    	    //view
    	    if($action == 'view' || $action == 'certlevel'){
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
    	    //search
    	    if($action =='search' || $action == 'info'){
    	    	switch ($errno){
    	    		case 0:
    	    			$msg = 'success';
    	    			break;
    	    		case 1:
    	    			$msg = 'no hospitals';
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
    	    //logout
    	    if($action =='logout'){
    	    	switch ($errno){
    	    		case 0:
    	    			$msg = '退出成功';
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
    	    			$msg = '账号不是邮箱';
    	    			break;
    	    		case 3:
    	    			$msg = '密码不存在';
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
    	    		case 200:
    	    			$msg = '未登录';
    	    			break;
    	    	}
    	    }
    	    //view
    	    if($action == 'view' || $action == 'certlevel'){
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
    	    //search
    	    if($action =='search' || $action == 'info'){
    	    	switch ($errno){
    	    		case 0:
    	    			$msg = '查找到医院';
    	    			break;
    	    		case 1:
    	    			$msg = '暂无拼配该名称的医院';
    	    			break;
    	    	}
    	    }
    	}
    	return $msg;
    }
}