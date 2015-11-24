<?php
class Application_Model_O_B_Nuser extends Application_Model_O_B_Object{
	protected $_mgt='Application_Model_M_Nuser';
    protected $isNew=true;
     
    protected $_id;
     
    /** 手机号 */ 
    protected $_mobile;
     
    /** 邮箱 */ 
    protected $_email;
     
    /** 电话 */ 
    protected $_phone;
     
    /** 密码 */ 
    protected $_passwd;
     
    /** 用户名 */ 
    protected $_name;
     
    /** 头像 */ 
    protected $_avatar;
     
    /** 1男，2女，3暂无 */ 
    protected $_sex;
     
    /** 职业 */ 
    protected $_job;
     
    /** 邮编 */ 
    protected $_postcode;
     
    /** 身份证号码 */ 
    protected $_idcard;
     
    /** 用户积分 */ 
    protected $_point;
     
    protected $_country;
     
    protected $_address;
     
    /** 出生日期 */ 
    protected $_birthday;
     
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
         
    public function setPasswd($value){
         
        if($value===$this->_passwd) return $this;
        $this->_modified_fields['passwd'] = $value;
     
		$this->_passwd = (string) $value;
		return $this;
	}
     
    /** 密码 */ 
	public function getPasswd(){
        return $this->_passwd;
	}
         
    public function setName($value){
         
        if($value===$this->_name) return $this;
        $this->_modified_fields['name'] = $value;
     
		$this->_name = (string) $value;
		return $this;
	}
     
    /** 用户名 */ 
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
         
    public function setJob($value){
         
        if($value===$this->_job) return $this;
        $this->_modified_fields['job'] = $value;
     
		$this->_job = (string) $value;
		return $this;
	}
     
    /** 职业 */ 
	public function getJob(){
        return $this->_job;
	}
         
    public function setPostcode($value){
         
        if($value===$this->_postcode) return $this;
        $this->_modified_fields['postcode'] = $value;
     
		$this->_postcode = (string) $value;
		return $this;
	}
     
    /** 邮编 */ 
	public function getPostcode(){
        return $this->_postcode;
	}
         
    public function setIdcard($value){
         
        if($value===$this->_idcard) return $this;
        $this->_modified_fields['idcard'] = $value;
     
		$this->_idcard = (string) $value;
		return $this;
	}
     
    /** 身份证号码 */ 
	public function getIdcard(){
        return $this->_idcard;
	}
         
    public function setPoint($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_point) return $this;
        $this->_modified_fields['point'] = $value;
     
		$this->_point = (integer) $value;
		return $this;
	}
     
    /** 用户积分 */ 
	public function getPoint(){
        return $this->_point;
	}
         
    public function setCountry($value){
         
        if($value===$this->_country) return $this;
        $this->_modified_fields['country'] = $value;
     
		$this->_country = (string) $value;
		return $this;
	}
     
	public function getCountry(){
        return $this->_country;
	}
         
    public function setAddress($value){
         
        if($value===$this->_address) return $this;
        $this->_modified_fields['address'] = $value;
     
		$this->_address = (string) $value;
		return $this;
	}
     
	public function getAddress(){
        return $this->_address;
	}
         
    public function setBirthday($value){
         
        if($value===$this->_birthday) return $this;
        $this->_modified_fields['birthday'] = $value;
     
		$this->_birthday = (string) $value;
		return $this;
	}
     
    /** 出生日期 */ 
	public function getBirthday(){
        return $this->_birthday;
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
        return $this->_status===null?1:$this->_status;
	}
    
    public function toArray(){
         $data = array(
                'id' => $this->getId(),
                        'mobile' =>$this->getMobile(),
                        'email' =>$this->getEmail(),
                        'phone' =>$this->getPhone(),
                        'passwd' =>$this->getPasswd(),
                        'name' =>$this->getName(),
                        'avatar' =>$this->getAvatar(),
                        'sex' =>$this->getSex(),
                        'job' =>$this->getJob(),
                        'postcode' =>$this->getPostcode(),
                        'idcard' =>$this->getIdcard(),
                        'point' =>$this->getPoint(),
                        'country' =>$this->getCountry(),
                        'address' =>$this->getAddress(),
                        'birthday' =>$this->getBirthday(),
                        'ctime' =>$this->getCtime(),
                        'utime' =>$this->getUtime(),
                        'status' =>$this->getStatus(),
                        );
        return $data;
    }
    public function delete(){
        $where = 'id='.$this->getId();
        return Application_Model_M_Nuser::delete($where);
    }
}
