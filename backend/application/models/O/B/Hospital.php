<?php
class Application_Model_O_B_Hospital extends Application_Model_O_B_Object{
	protected $_mgt='Application_Model_M_Hospital';
    protected $isNew=true;
     
    protected $_id;
     
    /** 医院名称 */ 
    protected $_name;
     
    /** 医院头像 */ 
    protected $_avatar;
     
    /** 邮箱 */ 
    protected $_email;
     
    /** 特色科室 */ 
    protected $_departments;
     
    /** 医院类型 */ 
    protected $_type;
     
    /** 认证级别 */ 
    protected $_certified;
     
    /** 地区 */ 
    protected $_city;
     
    /** 标签 */ 
    protected $_label;
     
    /** 国家 */ 
    protected $_country;
     
    /** 积分 */ 
    protected $_point;
     
    /** 所属洲 */ 
    protected $_area;
     
    protected $_passwd;
     
    /** 电话 */ 
    protected $_phone;
     
    /** 简介 */ 
    protected $_introduction;
     
    /** 经度 */ 
    protected $_longitude;
     
    /** 纬度 */ 
    protected $_latitude;
     
    /** 创建时间 */ 
    protected $_ctime;
     
    /** 更新时间 */ 
    protected $_utime;
     
    /** 用户状态，1可用，0禁用 */ 
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
     
    /** 医院名称 */ 
	public function getName(){
        return $this->_name;
	}
         
    public function setAvatar($value){
         
        if($value===$this->_avatar) return $this;
        $this->_modified_fields['avatar'] = $value;
     
		$this->_avatar = (string) $value;
		return $this;
	}
     
    /** 医院头像 */ 
	public function getAvatar(){
        return $this->_avatar;
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
         
    public function setDepartments($value){
         
        if($value===$this->_departments) return $this;
        $this->_modified_fields['departments'] = $value;
     
		$this->_departments = (string) $value;
		return $this;
	}
     
    /** 特色科室 */ 
	public function getDepartments(){
        return $this->_departments;
	}
         
    public function setType($value){
         
        if($value===$this->_type) return $this;
        $this->_modified_fields['type'] = $value;
     
		$this->_type = (string) $value;
		return $this;
	}
     
    /** 医院类型 */ 
	public function getType(){
        return $this->_type;
	}
         
    public function setCertified($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_certified) return $this;
        $this->_modified_fields['certified'] = $value;
     
		$this->_certified = (integer) $value;
		return $this;
	}
     
    /** 认证级别 */ 
	public function getCertified(){
        return $this->_certified;
	}
         
    public function setCity($value){
         
        if($value===$this->_city) return $this;
        $this->_modified_fields['city'] = $value;
     
		$this->_city = (string) $value;
		return $this;
	}
     
    /** 地区 */ 
	public function getCity(){
        return $this->_city;
	}
         
    public function setLabel($value){
         
        if($value===$this->_label) return $this;
        $this->_modified_fields['label'] = $value;
     
		$this->_label = (string) $value;
		return $this;
	}
     
    /** 标签 */ 
	public function getLabel(){
        return $this->_label;
	}
         
    public function setCountry($value){
         
        if($value===$this->_country) return $this;
        $this->_modified_fields['country'] = $value;
     
		$this->_country = (string) $value;
		return $this;
	}
     
    /** 国家 */ 
	public function getCountry(){
        return $this->_country;
	}
         
    public function setPoint($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_point) return $this;
        $this->_modified_fields['point'] = $value;
     
		$this->_point = (integer) $value;
		return $this;
	}
     
    /** 积分 */ 
	public function getPoint(){
        return $this->_point;
	}
         
    public function setArea($value){
         
        if($value===$this->_area) return $this;
        $this->_modified_fields['area'] = $value;
     
		$this->_area = (string) $value;
		return $this;
	}
     
    /** 所属洲 */ 
	public function getArea(){
        return $this->_area;
	}
         
    public function setPasswd($value){
         
        if($value===$this->_passwd) return $this;
        $this->_modified_fields['passwd'] = $value;
     
		$this->_passwd = (string) $value;
		return $this;
	}
     
	public function getPasswd(){
        return $this->_passwd;
	}
         
    public function setPhone($value){
         
        if($value===$this->_phone) return $this;
        $this->_modified_fields['phone'] = $value;
     
		$this->_phone = (string) $value;
		return $this;
	}
     
    /** 电话 */ 
	public function getPhone(){
        return $this->_phone;
	}
         
    public function setIntroduction($value){
         
        if($value===$this->_introduction) return $this;
        $this->_modified_fields['introduction'] = $value;
     
		$this->_introduction = (string) $value;
		return $this;
	}
     
    /** 简介 */ 
	public function getIntroduction(){
        return $this->_introduction;
	}
         
    public function setLongitude($value){
         
        if($value===$this->_longitude) return $this;
        $this->_modified_fields['longitude'] = $value;
     
		$this->_longitude = (string) $value;
		return $this;
	}
     
    /** 经度 */ 
	public function getLongitude(){
        return $this->_longitude;
	}
         
    public function setLatitude($value){
         
        if($value===$this->_latitude) return $this;
        $this->_modified_fields['latitude'] = $value;
     
		$this->_latitude = (string) $value;
		return $this;
	}
     
    /** 纬度 */ 
	public function getLatitude(){
        return $this->_latitude;
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
     
    /** 用户状态，1可用，0禁用 */ 
	public function getStatus(){
        return $this->_status;
	}
    
    public function toArray(){
         $data = array(
                'id' => $this->getId(),
                        'name' =>$this->getName(),
                        'avatar' =>$this->getAvatar(),
                        'email' =>$this->getEmail(),
                        'departments' =>$this->getDepartments(),
                        'type' =>$this->getType(),
                        'certified' =>$this->getCertified(),
                        'city' =>$this->getCity(),
                        'label' =>$this->getLabel(),
                        'country' =>$this->getCountry(),
                        'point' =>$this->getPoint(),
                        'area' =>$this->getArea(),
                        'passwd' =>$this->getPasswd(),
                        'phone' =>$this->getPhone(),
                        'introduction' =>$this->getIntroduction(),
                        'longitude' =>$this->getLongitude(),
                        'latitude' =>$this->getLatitude(),
                        'ctime' =>$this->getCtime(),
                        'utime' =>$this->getUtime(),
                        'status' =>$this->getStatus(),
                        );
        return $data;
    }
    public function delete(){
        $where = 'id='.$this->getId();
        return Application_Model_M_Hospital::delete($where);
    }
}
