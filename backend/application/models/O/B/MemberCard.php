<?php
class Application_Model_O_B_MemberCard extends Application_Model_O_B_Object{
	protected $_mgt='Application_Model_M_MemberCard';
    protected $isNew=true;
     
    protected $_id;
     
    /** 会员卡名 */ 
    protected $_name;
     
    /** 原价 */ 
    protected $_oprice;
     
    /** 现价 */ 
    protected $_dprice;
     
    /** 积分数 */ 
    protected $_points;
     
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
         
    public function setName($value){
         
        if($value===$this->_name) return $this;
        $this->_modified_fields['name'] = $value;
     
		$this->_name = (string) $value;
		return $this;
	}
     
    /** 会员卡名 */ 
	public function getName(){
        return $this->_name;
	}
         
    public function setOprice($value){
         
        if($value===$this->_oprice) return $this;
        $this->_modified_fields['oprice'] = $value;
     
		$this->_oprice = (string) $value;
		return $this;
	}
     
    /** 原价 */ 
	public function getOprice(){
        return $this->_oprice;
	}
         
    public function setDprice($value){
         
        if($value===$this->_dprice) return $this;
        $this->_modified_fields['dprice'] = $value;
     
		$this->_dprice = (string) $value;
		return $this;
	}
     
    /** 现价 */ 
	public function getDprice(){
        return $this->_dprice;
	}
         
    public function setPoints($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_points) return $this;
        $this->_modified_fields['points'] = $value;
     
		$this->_points = (integer) $value;
		return $this;
	}
     
    /** 积分数 */ 
	public function getPoints(){
        return $this->_points;
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
                        'name' =>$this->getName(),
                        'oprice' =>$this->getOprice(),
                        'dprice' =>$this->getDprice(),
                        'points' =>$this->getPoints(),
                        'ctime' =>$this->getCtime(),
                        'utime' =>$this->getUtime(),
                        'status' =>$this->getStatus(),
                        );
        return $data;
    }
    public function delete(){
        $where = 'id='.$this->getId();
        return Application_Model_M_MemberCard::delete($where);
    }
}
