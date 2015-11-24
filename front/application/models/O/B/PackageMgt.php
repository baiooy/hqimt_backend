<?php
class Application_Model_O_B_PackageMgt extends Application_Model_O_B_Object{
	protected $_mgt='Application_Model_M_PackageMgt';
    protected $isNew=true;
     
    protected $_id;
     
    /** 软件包名称 */ 
    protected $_name;
     
    /** 描述 */ 
    protected $_description;
     
    /** 软件包的版本 */ 
    protected $_version;
     
    /** 客户端系统，iPhone，Android */ 
    protected $_platform;
     
    /** 软件包访问路径 */ 
    protected $_url;
     
    /** 创建时间 */ 
    protected $_ctime;
     
    /** 更新时间 */ 
    protected $_utime;
     
    /** 状态：1显示，0不显示 */ 
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
         
    public function setName($value){
         
        if($value===$this->_name) return $this;
        $this->_modified_fields['name'] = $value;
     
		$this->_name = (string) $value;
		return $this;
	}
     
    /** 软件包名称 */ 
	public function getName(){
        return $this->_name;
	}
         
    public function setDescription($value){
         
        if($value===$this->_description) return $this;
        $this->_modified_fields['description'] = $value;
     
		$this->_description = (string) $value;
		return $this;
	}
     
    /** 描述 */ 
	public function getDescription(){
        return $this->_description;
	}
         
    public function setVersion($value){
         
        if($value===$this->_version) return $this;
        $this->_modified_fields['version'] = $value;
     
		$this->_version = (string) $value;
		return $this;
	}
     
    /** 软件包的版本 */ 
	public function getVersion(){
        return $this->_version;
	}
         
    public function setPlatform($value){
         
        if($value===$this->_platform) return $this;
        $this->_modified_fields['platform'] = $value;
     
		$this->_platform = (string) $value;
		return $this;
	}
     
    /** 客户端系统，iPhone，Android */ 
	public function getPlatform(){
        return $this->_platform;
	}
         
    public function setUrl($value){
         
        if($value===$this->_url) return $this;
        $this->_modified_fields['url'] = $value;
     
		$this->_url = (string) $value;
		return $this;
	}
     
    /** 软件包访问路径 */ 
	public function getUrl(){
        return $this->_url;
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
     
    /** 状态：1显示，0不显示 */ 
	public function getStatus(){
        return $this->_status===null?1:$this->_status;
	}
    
    public function toArray(){
         $data = array(
                'id' => $this->getId(),
                        'name' =>$this->getName(),
                        'description' =>$this->getDescription(),
                        'version' =>$this->getVersion(),
                        'platform' =>$this->getPlatform(),
                        'url' =>$this->getUrl(),
                        'ctime' =>$this->getCtime(),
                        'utime' =>$this->getUtime(),
                        'status' =>$this->getStatus(),
                        );
        return $data;
    }
    public function delete(){
        $where = 'id='.$this->getId();
        return Application_Model_M_PackageMgt::delete($where);
    }
}
