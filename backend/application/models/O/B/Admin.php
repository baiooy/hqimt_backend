<?php
class Application_Model_O_B_Admin extends Application_Model_O_B_Object{
	protected $_mgt='Application_Model_M_Admin';
    protected $isNew=true;
     
    protected $_id;
     
    /** 管理员姓名 */ 
    protected $_account;
     
    /** 管理员密码 */ 
    protected $_passwd;
     
    /** 管理员角色 */ 
    protected $_role;
     
    protected $_ctime;
     
    protected $_utime;
     
    /** 1有效，0无效 */ 
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
         
    public function setAccount($value){
         
        if($value===$this->_account) return $this;
        $this->_modified_fields['account'] = $value;
     
		$this->_account = (string) $value;
		return $this;
	}
     
    /** 管理员姓名 */ 
	public function getAccount(){
        return $this->_account;
	}
         
    public function setPasswd($value){
         
        if($value===$this->_passwd) return $this;
        $this->_modified_fields['passwd'] = $value;
     
		$this->_passwd = (string) $value;
		return $this;
	}
     
    /** 管理员密码 */ 
	public function getPasswd(){
        return $this->_passwd;
	}
         
    public function setRole($value){
         
        if($value===$this->_role) return $this;
        $this->_modified_fields['role'] = $value;
     
		$this->_role = (string) $value;
		return $this;
	}
     
    /** 管理员角色 */ 
	public function getRole(){
        return $this->_role;
	}
         
    public function setCtime($value){
         
        if($value===$this->_ctime) return $this;
        $this->_modified_fields['ctime'] = $value;
     
		$this->_ctime = (string) $value;
		return $this;
	}
     
	public function getCtime(){
        return $this->_ctime;
	}
         
    public function setUtime($value){
         
        if($value===$this->_utime) return $this;
        $this->_modified_fields['utime'] = $value;
     
		$this->_utime = (string) $value;
		return $this;
	}
     
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
     
    /** 1有效，0无效 */ 
	public function getStatus(){
        return $this->_status===null?1:$this->_status;
	}
    
    public function toArray(){
         $data = array(
                'id' => $this->getId(),
                        'account' =>$this->getAccount(),
                        'passwd' =>$this->getPasswd(),
                        'role' =>$this->getRole(),
                        'ctime' =>$this->getCtime(),
                        'utime' =>$this->getUtime(),
                        'status' =>$this->getStatus(),
                        );
        return $data;
    }
    public function delete(){
        $where = 'id='.$this->getId();
        return Application_Model_M_Admin::delete($where);
    }
}
