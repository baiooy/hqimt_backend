<?php
class Application_Model_O_B_Doctor extends Application_Model_O_B_Object{
	protected $_mgt='Application_Model_M_Doctor';
    protected $isNew=true;
     
    protected $_id;
     
    /** 医生姓名 */ 
    protected $_name;
     
    /** 头像 */ 
    protected $_avatar;
     
    /** 1男，2女，3暂无 */ 
    protected $_sex;
     
    /** 生日 */ 
    protected $_birthday;
     
    /** 邮箱 */ 
    protected $_email;
     
    /** 登录密码 */ 
    protected $_passwd;
     
    /** 电话 */ 
    protected $_phone;
     
    /** 科室 */ 
    protected $_department;
     
    /** 积分 */ 
    protected $_point;
     
    /** 所在城市 */ 
    protected $_city;
     
    /** 认证级别 */ 
    protected $_certified;
     
    /** 擅长 */ 
    protected $_special;
     
    /** 国家 */ 
    protected $_country;
     
    /** 简介 */ 
    protected $_introduction;
     
    /** 所属医院 */ 
    protected $_hospital;
     
    /** 所属洲 */ 
    protected $_area;
     
    /** 资质 */ 
    protected $_qualification;
     
    /** 该医生预约费用 */ 
    protected $_reservation_fee;
     
    /** 预约人数 */ 
    protected $_reservation_number;
     
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
     
    /** 医生姓名 */ 
	public function getName(){
        return $this->_name;
	}
         
    public function setAvatar($value){
         
        if($value===$this->_avatar) return $this;
        $this->_modified_fields['avatar'] = $value;
     
		$this->_avatar = (string) $value;
		return $this;
	}
     
    /** 头像 */ 
	public function getAvatar(){
        return $this->_avatar;
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
         
    public function setBirthday($value){
         
        if($value===$this->_birthday) return $this;
        $this->_modified_fields['birthday'] = $value;
     
		$this->_birthday = (string) $value;
		return $this;
	}
     
    /** 生日 */ 
	public function getBirthday(){
        return $this->_birthday;
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
         
    public function setPasswd($value){
         
        if($value===$this->_passwd) return $this;
        $this->_modified_fields['passwd'] = $value;
     
		$this->_passwd = (string) $value;
		return $this;
	}
     
    /** 登录密码 */ 
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
         
    public function setDepartment($value){
         
        if($value===$this->_department) return $this;
        $this->_modified_fields['department'] = $value;
     
		$this->_department = (string) $value;
		return $this;
	}
     
    /** 科室 */ 
	public function getDepartment(){
        return $this->_department;
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
         
    public function setCity($value){
         
        if($value===$this->_city) return $this;
        $this->_modified_fields['city'] = $value;
     
		$this->_city = (string) $value;
		return $this;
	}
     
    /** 所在城市 */ 
	public function getCity(){
        return $this->_city;
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
         
    public function setSpecial($value){
         
        if($value===$this->_special) return $this;
        $this->_modified_fields['special'] = $value;
     
		$this->_special = (string) $value;
		return $this;
	}
     
    /** 擅长 */ 
	public function getSpecial(){
        return $this->_special;
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
         
    public function setHospital($value){
         
        if($value===$this->_hospital) return $this;
        $this->_modified_fields['hospital'] = $value;
     
		$this->_hospital = (string) $value;
		return $this;
	}
     
    /** 所属医院 */ 
	public function getHospital(){
        return $this->_hospital;
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
         
    public function setQualification($value){
         
        if($value===$this->_qualification) return $this;
        $this->_modified_fields['qualification'] = $value;
     
		$this->_qualification = (string) $value;
		return $this;
	}
     
    /** 资质 */ 
	public function getQualification(){
        return $this->_qualification;
	}
         
    public function setReservation_fee($value){
         
        if($value===$this->_reservation_fee) return $this;
        $this->_modified_fields['reservation_fee'] = $value;
     
		$this->_reservation_fee = (string) $value;
		return $this;
	}
     
    /** 该医生预约费用 */ 
	public function getReservation_fee(){
        return $this->_reservation_fee;
	}
         
    public function setReservation_number($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_reservation_number) return $this;
        $this->_modified_fields['reservation_number'] = $value;
     
		$this->_reservation_number = (integer) $value;
		return $this;
	}
     
    /** 预约人数 */ 
	public function getReservation_number(){
        return $this->_reservation_number;
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
                        'sex' =>$this->getSex(),
                        'birthday' =>$this->getBirthday(),
                        'email' =>$this->getEmail(),
                        'passwd' =>$this->getPasswd(),
                        'phone' =>$this->getPhone(),
                        'department' =>$this->getDepartment(),
                        'point' =>$this->getPoint(),
                        'city' =>$this->getCity(),
                        'certified' =>$this->getCertified(),
                        'special' =>$this->getSpecial(),
                        'country' =>$this->getCountry(),
                        'introduction' =>$this->getIntroduction(),
                        'hospital' =>$this->getHospital(),
                        'area' =>$this->getArea(),
                        'qualification' =>$this->getQualification(),
                        'reservation_fee' =>$this->getReservation_fee(),
                        'reservation_number' =>$this->getReservation_number(),
                        'ctime' =>$this->getCtime(),
                        'utime' =>$this->getUtime(),
                        'status' =>$this->getStatus(),
                        );
        return $data;
    }
    public function delete(){
        $where = 'id='.$this->getId();
        return Application_Model_M_Doctor::delete($where);
    }
}
