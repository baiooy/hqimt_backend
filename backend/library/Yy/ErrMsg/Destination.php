<?php
class Yy_ErrMsg_Destination implements Yy_ErrMsg_Interface{
	public static function getMsg($action,$errno){
	    $msg = '';
	    if(@$_GET['lang'] == 1){
	        if($action =='index'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'no destination';
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
	        //hospital
	        if($action =='hospital'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'no hospital';
	        			break;
	        	}
	        }
	        //travel
	        if($action =='travel'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'no travel';
	        			break;
	        	}
	        }
	        //image
	        if($action =='image'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'no image';
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
	        //hospital
	        if($action =='hospital'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '有推荐医院';
	        			break;
	        		case 1:
	        			$msg = '暂无推荐医院';
	        			break;
	        	}
	        }
	        //travel
	        if($action =='travel'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '有推荐行程';
	        			break;
	        		case 1:
	        			$msg = '暂无推荐行程';
	        			break;
	        	}
	        }
	        //image
	        if($action =='image'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '有图片';
	        			break;
	        		case 1:
	        			$msg = '无图片';
	        			break;
	        	}
	        }
	    }
	    return $msg;
	}
}