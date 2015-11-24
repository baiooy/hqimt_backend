<?php
class Yy_ErrMsg_Costperf implements Yy_ErrMsg_Interface{
	public static function getMsg($action,$errno){
	    $msg = '';
	    if(@$_GET['lang'] == 1 || @$_POST['lang'] == 1){
	        if($action =='index'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'no costperfs';
	        			break;
	        	}
	        }
	        //price
	        if($action =='price'){
	        	switch ($errno){
	        		case 0:
	        			$msg = 'success';
	        			break;
	        		case 1:
	        			$msg = 'no departments';
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
	    }else{//中文
	        //index
	        if($action =='index'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '成功';
	        			break;
	        		case 1:
	        			$msg = '暂无性价比导航';
	        			break;
	        	}
	        }
	        //price
	        if($action =='price'){
	        	switch ($errno){
	        		case 0:
	        			$msg = '成功';
	        			break;
	        		case 1:
	        			$msg = '暂无该手术项目';
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
	    }
	    return $msg;
	}
}