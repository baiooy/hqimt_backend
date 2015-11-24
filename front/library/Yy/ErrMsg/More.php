<?php
class Yy_ErrMsg_More implements Yy_ErrMsg_Interface{
	public static function getMsg($action,$errno){
	    $msg = '';
	    if(@$_GET['lang'] == 1 || @$_POST['lang'] == 1){
	        if($action =='feedback'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'feedback failed';
	        			break;
	        	}
	        }
	         
	        //phone
	        if($action =='phone'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'no phone';
	        			break;
	        	}
	        }
	        
	        //checkup
	        if($action =='checkup'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'Need to be update';
	        			break;
	        		case 1:
	        			$msg = 'Is the latest version';
	        			break;
	        		case 255:
	        			$msg = 'exception';
	        			break;
	        	}
	        }
	        //article
	        if($action =='article'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'no article';
	        			break;
	        	}
	        }	                 
	    }else{//中文
	        //feedback
	        if($action =='feedback'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '成功';
	        			break;
	        		case 1:
	        			$msg = '反馈失败';
	        			break;
	        	}
	        }
	        //phone
	        if($action =='phone'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '有结果';
	        			break;
	        		case 1:
	        			$msg = '无结果';
	        			break;
	        	}
	        }
	        
	        //checkup
	        if($action =='checkup'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '需要更新';
	        			break;
	        		case 1:
	        			$msg = '已经是最新版';
	        			break;
	        		case 255:
	        			$msg = '异常错误';
	        			break;
	        	}
	        }
	        
	        //article
	        if($action =='article'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '成功';
	        			break;
	        		case 1:
	        			$msg = '暂无帮助';
	        			break;
	        	}
	        }
	    }
	    return $msg;
	}
}