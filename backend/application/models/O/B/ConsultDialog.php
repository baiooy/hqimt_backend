<?php
class Application_Model_O_B_ConsultDialog extends Application_Model_O_B_Object{
	protected $_mgt='Application_Model_M_ConsultDialog';
    protected $isNew=true;
     
    protected $_id;
     
    /** 发消息人，前缀（1普通用户，2医生，3医院） */ 
    protected $_from_user;
     
    /** 1普通用户，2医生，3医院 */ 
    protected $_from_role;
     
    /** 消息到的人，前缀（1普通用户，2医生，3医院） */ 
    protected $_to_user;
     
    /** 1普通用户，2医生，3医院 */ 
    protected $_to_role;
     
    /** 对话内容 */ 
    protected $_message;
     
    /** 创建时间 */ 
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
         
    public function setFrom_user($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_from_user) return $this;
        $this->_modified_fields['from_user'] = $value;
     
		$this->_from_user = (integer) $value;
		return $this;
	}
     
    /** 发消息人，前缀（1普通用户，2医生，3医院） */ 
	public function getFrom_user(){
        return $this->_from_user;
	}
         
    public function setFrom_role($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_from_role) return $this;
        $this->_modified_fields['from_role'] = $value;
     
		$this->_from_role = (integer) $value;
		return $this;
	}
     
    /** 1普通用户，2医生，3医院 */ 
	public function getFrom_role(){
        return $this->_from_role;
	}
         
    public function setTo_user($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_to_user) return $this;
        $this->_modified_fields['to_user'] = $value;
     
		$this->_to_user = (integer) $value;
		return $this;
	}
     
    /** 消息到的人，前缀（1普通用户，2医生，3医院） */ 
	public function getTo_user(){
        return $this->_to_user;
	}
         
    public function setTo_role($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_to_role) return $this;
        $this->_modified_fields['to_role'] = $value;
     
		$this->_to_role = (integer) $value;
		return $this;
	}
     
    /** 1普通用户，2医生，3医院 */ 
	public function getTo_role(){
        return $this->_to_role;
	}
         
    public function setMessage($value){
         
        if($value===$this->_message) return $this;
        $this->_modified_fields['message'] = $value;
     
		$this->_message = (string) $value;
		return $this;
	}
     
    /** 对话内容 */ 
	public function getMessage(){
        return $this->_message;
	}
         
    public function setCtime($value){
         
        if($value===$this->_ctime) return $this;
        $this->_modified_fields['ctime'] = $value;
     
		$this->_ctime = (string) $value;
		return $this;
	}
     
    /** 创建时间 */ 
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
                        'from_user' =>$this->getFrom_user(),
                        'from_role' =>$this->getFrom_role(),
                        'to_user' =>$this->getTo_user(),
                        'to_role' =>$this->getTo_role(),
                        'message' =>$this->getMessage(),
                        'ctime' =>$this->getCtime(),
                        'utime' =>$this->getUtime(),
                        'status' =>$this->getStatus(),
                        );
        return $data;
    }
    public function delete(){
        $where = 'id='.$this->getId();
        return Application_Model_M_ConsultDialog::delete($where);
    }
}
