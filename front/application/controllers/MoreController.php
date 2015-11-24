<?php
/*
 * 更多
 */
class MoreController extends Zend_Controller_Action
{

    public function init()
    {
    	$this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
    }

    /*
     * 意见反馈
     */
    public function feedbackAction()
    {
        $content    = $this->_getParam('content');
        $contact    = $this->_getParam('contact');
        if(!$content && !$contact){
        	$out['errno'] = '1';
        	$out['msg'] = Yy_ErrMsg_More::getMsg('feedback', $out['errno']);
        	Yy_Utils::jsonOut($out);
        	return;
        }
        $feedback   = new Application_Model_O_Feedback();
        $feedback
                 ->setContent($content)
                 ->setContact($contact)
                 ->setCtime(date('Y-m-d H:i:s'))
                 ->setStatus(1)
                 ;
         try {
            Application_Model_M_Feedback::save($feedback);
            $out['errno']   = '0';
        }catch (Zend_Db_Exception $e){
            echo $e->getMessage();
        	$out['errno']  = '1';
        }
        $out['msg'] = Yy_ErrMsg_More::getMsg('feedback', $out['errno']);
        Yy_Utils::jsonOut($out);
    }
    
    /*
     * 获取虹桥呼叫中心电话
     */
    public function phoneAction(){
        $data    = Application_Model_M_Article::fetchByType(4);
        if(count($data)>0){
        	$out['errno'] = '0';
        	$records = array();
        	foreach ($data as $Application_Model_O_Article){
        		$record = array(
        			     'type'  => $Application_Model_O_Article->getTitle(),
        		         'number' => $Application_Model_O_Article->getContent(),
        		          );
        		array_push($records, $record);
        	}
        	$out['phone']  = $records;
        }else{
        	$out['errno'] = '1';
        }
        $out['msg'] = Yy_ErrMsg_More::getMsg('phone', $out['errno']);
    	Yy_Utils::jsonOut($out);
    }
    
    public function checkupAction(){
        $v  = $this->_getParam('v');
        $os = $this->_getParam('os');
        if(!$v || !$os){
        	$out['errno'] = '255';
        	$out['msg']   = Yy_ErrMsg_More::getMsg('checkup', $out['errno']);
        	Yy_Utils::jsonOut($out);
        	return;
        }
        $packagemgt  = Application_Model_M_PackageMgt::fetchByPlatform($os);
        if($packagemgt){
        	$lastv = $packagemgt->getVersion();
        	if($lastv > $v){
        		$out['errno']  = '0';
        		$out['desc']   = $packagemgt->getDescription();
        		$out['url']    = $packagemgt->getUrl();
        	}else{
        		$out['errno'] = '1';
        	}
        }else{
        	$out['errno'] = '1';
        }
        $out['msg'] = Yy_ErrMsg_More::getMsg('checkup', $out['errno']);
        Yy_Utils::jsonOut($out);
    }
    
    /*
     * 1帮助中心，2法律问题，3关于我们
     */
    public function articleAction(){
        $type = $this->_getParam('type',1); //类型：1帮助中心，2法律问题，3关于我们
        
        $data    = Application_Model_M_Article::fetchByType(1);
    	if(count($data)>0){
    	    $out['errno']    = '0';
    		$records   = array();
    		foreach ($data as $k=>$Application_Model_O_Article){
    			$record = array(
    				'title'     => $Application_Model_O_Article->getTitle(),
    			    'content'   => $Application_Model_O_Article->getContent(),
    			    'img'       => Application_Model_M_Article::getImageUrl($Application_Model_O_Article->getId()), 
    			);
    			$records[] = $record;
    		}
    		$out['article'] = $records;
    	}else{
    		$out['errno'] = '1';
    		$out['msg']   = Yy_ErrMsg_More::getMsg('article', $out['errno']);
    	}
    	Yy_Utils::jsonOut($out);
    }
    
    public function artimageAction(){
    	$this->getResponse()->setHeader('Content-Type', 'image/png');
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    
    	$id = $this->_getParam('id');
    	$img   = Application_Model_M_Article::getImage($id);
    	echo $img;
    }

}

