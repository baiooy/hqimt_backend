<?php
class Application_Model_O_B_GlobalConsultationApply extends Application_Model_O_B_Object{
	protected $_mgt='Application_Model_M_GlobalConsultationApply';
    protected $isNew=true;
     
    protected $_id;
     
    protected $_department_category_id;
     
    protected $_department_id;
     
    /** 邮箱 */ 
    protected $_email;
     
    /** 手机号 */ 
    protected $_mobile;
     
    /** 年龄 */ 
    protected $_age;
     
    /** 1男，2女，3暂无 */ 
    protected $_sex;
     
    /** 位置 */ 
    protected $_location;
     
    /** 何时治疗 */ 
    protected $_treatment_time;
     
    /** 建议和想法 */ 
    protected $_opinion;
     
    /** 病例报告 */ 
    protected $_report;
     
    /** 创建时间 */ 
    protected $_ctime;
     
    /** 更新时间 */ 
    protected $_utime;
     
    /** 1可用，0禁用 */ 
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
         
    public function setDepartment_category_id($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_department_category_id) return $this;
        $this->_modified_fields['department_category_id'] = $value;
     
		$this->_department_category_id = (integer) $value;
		return $this;
	}
     
	public function getDepartment_category_id(){
        return $this->_department_category_id;
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
         
    public function setEmail($value){
         
        if($value===$this->_email) return $this;
        $this->_modified_fields['email'] = $value;
     
		$this->_email = (string) $value;
		return $this;
	}
     
    /** 邮箱 */ 
	public function getEmail(){
        return $this->_email;
	}
         
    public function setMobile($value){
         
        if($value===$this->_mobile) return $this;
        $this->_modified_fields['mobile'] = $value;
     
		$this->_mobile = (string) $value;
		return $this;
	}
     
    /** 手机号 */ 
	public function getMobile(){
        return $this->_mobile;
	}
         
    public function setAge($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_age) return $this;
        $this->_modified_fields['age'] = $value;
     
		$this->_age = (integer) $value;
		return $this;
	}
     
    /** 年龄 */ 
	public function getAge(){
        return $this->_age;
	}
         
    public function setSex($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_sex) return $this;
        $this->_modified_fields['sex'] = $value;
     
		$this->_sex = (integer) $value;
		return $this;
	}
     
    /** 1男，2女，3暂无 */ 
	public function getSex(){
        return $this->_sex===null?3:$this->_sex;
	}
         
    public function setLocation($value){
         
        if($value===$this->_location) return $this;
        $this->_modified_fields['location'] = $value;
     
		$this->_location = (string) $value;
		return $this;
	}
     
    /** 位置 */ 
	public function getLocation(){
        return $this->_location;
	}
         
    public function setTreatment_time($value){
         
        if($value===$this->_treatment_time) return $this;
        $this->_modified_fields['treatment_time'] = $value;
     
		$this->_treatment_time = (string) $value;
		return $this;
	}
     
    /** 何时治疗 */ 
	public function getTreatment_time(){
        return $this->_treatment_time;
	}
         
    public function setOpinion($value){
         
        if($value===$this->_opinion) return $this;
        $this->_modified_fields['opinion'] = $value;
     
		$this->_opinion = (string) $value;
		return $this;
	}
     
    /** 建议和想法 */ 
	public function getOpinion(){
        return $this->_opinion;
	}
         
    public function setReport($value){
         
        if($value===$this->_report) return $this;
        $this->_modified_fields['report'] = $value;
     
		$this->_report = (string) $value;
		return $this;
	}
     
    /** 病例报告 */ 
	public function getReport(){
        return $this->_report;
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
     
    /** 1可用，0禁用 */ 
	public function getStatus(){
        return $this->_status===null?1:$this->_status;
	}
    
    public function toArray(){
         $data = array(
                'id' => $this->getId(),
                        'department_category_id' =>$this->getDepartment_category_id(),
                        'department_id' =>$this->getDepartment_id(),
                        'email' =>$this->getEmail(),
                        'mobile' =>$this->getMobile(),
                        'age' =>$this->getAge(),
                        'sex' =>$this->getSex(),
                        'location' =>$this->getLocation(),
                        'treatment_time' =>$this->getTreatment_time(),
                        'opinion' =>$this->getOpinion(),
                        'report' =>$this->getReport(),
                        'ctime' =>$this->getCtime(),
                        'utime' =>$this->getUtime(),
                        'status' =>$this->getStatus(),
                        );
        return $data;
    }
    public function delete(){
        $where = 'id='.$this->getId();
        return Application_Model_M_GlobalConsultationApply::delete($where);
    }
}
