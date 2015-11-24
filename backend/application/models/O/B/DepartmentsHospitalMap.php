<?php
class Application_Model_O_B_DepartmentsHospitalMap extends Application_Model_O_B_Object{
	protected $_mgt='Application_Model_M_DepartmentsHospitalMap';
    protected $isNew=true;
     
    protected $_id;
     
    protected $_department_id;
     
    protected $_hospital_id;
     
    /** 排序 */ 
    protected $_sort;
     
    /** 创建时间 */ 
    protected $_ctime;
     
    /** 更新时间 */ 
    protected $_utime;
     
    /** 状态,1显示，0不显示 */ 
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
         
    public function setDepartment_id($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_department_id) return $this;
        $this->_modified_fields['department_id'] = $value;
     
		$this->_department_id = (integer) $value;
		return $this;
	}
     
	public function getDepartment_id(){
        return $this->_department_id;
	}
         
    public function setHospital_id($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_hospital_id) return $this;
        $this->_modified_fields['hospital_id'] = $value;
     
		$this->_hospital_id = (integer) $value;
		return $this;
	}
     
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
     
    /** 状态,1显示，0不显示 */ 
	public function getStatus(){
        return $this->_status===null?1:$this->_status;
	}
    
    public function toArray(){
         $data = array(
                'id' => $this->getId(),
                        'department_id' =>$this->getDepartment_id(),
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
        return Application_Model_M_DepartmentsHospitalMap::delete($where);
    }
}
