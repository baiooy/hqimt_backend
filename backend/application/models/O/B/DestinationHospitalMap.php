<?php
class Application_Model_O_B_DestinationHospitalMap extends Application_Model_O_B_Object{
	protected $_mgt='Application_Model_M_DestinationHospitalMap';
    protected $isNew=true;
     
    protected $_id;
     
    /** 目的地ID */ 
    protected $_destination_id;
     
    /** 医院ID */ 
    protected $_hospital_id;
     
    /** 排序 */ 
    protected $_sort;
     
    /** 创建时间 */ 
    protected $_ctime;
     
    /** 更新时间 */ 
    protected $_utime;
     
    /** 状态 */ 
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
         
    public function setDestination_id($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_destination_id) return $this;
        $this->_modified_fields['destination_id'] = $value;
     
		$this->_destination_id = (integer) $value;
		return $this;
	}
     
    /** 目的地ID */ 
	public function getDestination_id(){
        return $this->_destination_id;
	}
         
    public function setHospital_id($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_hospital_id) return $this;
        $this->_modified_fields['hospital_id'] = $value;
     
		$this->_hospital_id = (integer) $value;
		return $this;
	}
     
    /** 医院ID */ 
	public function getHospital_id(){
        return $this->_hospital_id;
	}
         
    public function setSort($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_sort) return $this;
        $this->_modified_fields['sort'] = $value;
     
		$this->_sort = (integer) $value;
		return $this;
	}
     
    /** 排序 */ 
	public function getSort(){
        return $this->_sort===null?1:$this->_sort;
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
     
    /** 状态 */ 
	public function getStatus(){
        return $this->_status===null?1:$this->_status;
	}
    
    public function toArray(){
         $data = array(
                'id' => $this->getId(),
                        'destination_id' =>$this->getDestination_id(),
                        'hospital_id' =>$this->getHospital_id(),
                        'sort' =>$this->getSort(),
                        'ctime' =>$this->getCtime(),
                        'utime' =>$this->getUtime(),
                        'status' =>$this->getStatus(),
                        );
        return $data;
    }
    public function delete(){
        $where = 'id='.$this->getId();
        return Application_Model_M_DestinationHospitalMap::delete($where);
    }
}
