<?php
class Application_Model_O_B_Feedback extends Application_Model_O_B_Object{
	protected $_mgt='Application_Model_M_Feedback';
    protected $isNew=true;
     
    protected $_id;
     
    /** 反馈内容 */ 
    protected $_content;
     
    /** 反馈者联系方式 */ 
    protected $_contact;
     
    /** 反馈时间 */ 
    protected $_ctime;
     
    /** 更新时间 */ 
    protected $_utime;
     
    /** 1显示，0不显示 */ 
    protected $_status;
     

    public function isNew(){
        return $this->isNew;
    }

    public function setNew($flag){
        $this->isNew=$flag;
        $this->_modified_fields = array();
    }
         
    public function setId($value){
            $this->isNew = false;           
     
		$this->_id = (integer) $value;
		return $this;
	}
     
	public function getId(){
        return $this->_id;
	}
         
    public function setContent($value){
         
        if($value===$this->_content) return $this;
        $this->_modified_fields['content'] = $value;
     
		$this->_content = (string) $value;
		return $this;
	}
     
    /** 反馈内容 */ 
	public function getContent(){
        return $this->_content;
	}
         
    public function setContact($value){
         
        if($value===$this->_contact) return $this;
        $this->_modified_fields['contact'] = $value;
     
		$this->_contact = (string) $value;
		return $this;
	}
     
    /** 反馈者联系方式 */ 
	public function getContact(){
        return $this->_contact;
	}
         
    public function setCtime($value){
         
        if($value===$this->_ctime) return $this;
        $this->_modified_fields['ctime'] = $value;
     
		$this->_ctime = (string) $value;
		return $this;
	}
     
    /** 反馈时间 */ 
	public function getCtime(){
        return $this->_ctime;
	}
         
    public function setUtime($value){
         
        if($value===$this->_utime) return $this;
        $this->_modified_fields['utime'] = $value;
     
		$this->_utime = (string) $value;
		return $this;
	}
     
    /** 更新时间 */ 
	public function getUtime(){
        return $this->_utime;
	}
         
    public function setStatus($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_status) return $this;
        $this->_modified_fields['status'] = $value;
     
		$this->_status = (integer) $value;
		return $this;
	}
     
    /** 1显示，0不显示 */ 
	public function getStatus(){
        return $this->_status===null?1:$this->_status;
	}
    
    public function toArray(){
         $data = array(
                'id' => $this->getId(),
                        'content' =>$this->getContent(),
                        'contact' =>$this->getContact(),
                        'ctime' =>$this->getCtime(),
                        'utime' =>$this->getUtime(),
                        'status' =>$this->getStatus(),
                        );
        return $data;
    }
    public function delete(){
        $where = 'id='.$this->getId();
        return Application_Model_M_Feedback::delete($where);
    }
}
