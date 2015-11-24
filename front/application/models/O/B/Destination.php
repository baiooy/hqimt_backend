<?php
class Application_Model_O_B_Destination extends Application_Model_O_B_Object{
	protected $_mgt='Application_Model_M_Destination';
    protected $isNew=true;
     
    protected $_id;
     
    /** 城市 */ 
    protected $_city;
     
    /** 1国内，2国外 */ 
    protected $_type;
     
    /** 经度 */ 
    protected $_longitude;
     
    /** 纬度 */ 
    protected $_latitude;
     
    /** 图片 */ 
    protected $_img;
     
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
         
    public function setCity($value){
         
        if($value===$this->_city) return $this;
        $this->_modified_fields['city'] = $value;
     
		$this->_city = (string) $value;
		return $this;
	}
     
    /** 城市 */ 
	public function getCity(){
        return $this->_city;
	}
         
    public function setType($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_type) return $this;
        $this->_modified_fields['type'] = $value;
     
		$this->_type = (integer) $value;
		return $this;
	}
     
    /** 1国内，2国外 */ 
	public function getType(){
        return $this->_type===null?1:$this->_type;
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
         
    public function setImg($value){
         
        if($value===$this->_img) return $this;
        $this->_modified_fields['img'] = $value;
     
		$this->_img = (string) $value;
		return $this;
	}
     
    /** 图片 */ 
	public function getImg(){
        return $this->_img;
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
                        'city' =>$this->getCity(),
                        'type' =>$this->getType(),
                        'longitude' =>$this->getLongitude(),
                        'latitude' =>$this->getLatitude(),
                        'img' =>$this->getImg(),
                        'sort' =>$this->getSort(),
                        'ctime' =>$this->getCtime(),
                        'utime' =>$this->getUtime(),
                        'status' =>$this->getStatus(),
                        );
        return $data;
    }
    public function delete(){
        $where = 'id='.$this->getId();
        return Application_Model_M_Destination::delete($where);
    }
}
