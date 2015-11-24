<?php
class Application_Model_O_B_Travel extends Application_Model_O_B_Object{
	protected $_mgt='Application_Model_M_Travel';
    protected $isNew=true;
     
    protected $_id;
     
    /** 1体检与疗养，2看病，3美容与抗衰老 */ 
    protected $_type;
     
    /** 1国内，2国外 */ 
    protected $_location_type;
     
    /** 成人原价 */ 
    protected $_adult_oprice;
     
    /** 成人现价 */ 
    protected $_adult_dprice;
     
    /** 儿童原价 */ 
    protected $_child_oprice;
     
    /** 儿童现价 */ 
    protected $_child_dprice;
     
    /** 地区 */ 
    protected $_area;
     
    /** 已卖票数 */ 
    protected $_sales;
     
    /** 大标题 */ 
    protected $_title;
     
    /** 小标题 */ 
    protected $_subtitle;
     
    /** 展示图片 */ 
    protected $_img;
     
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
         
    public function setType($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_type) return $this;
        $this->_modified_fields['type'] = $value;
     
		$this->_type = (integer) $value;
		return $this;
	}
     
    /** 1体检与疗养，2看病，3美容与抗衰老 */ 
	public function getType(){
        return $this->_type;
	}
         
    public function setLocation_type($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_location_type) return $this;
        $this->_modified_fields['location_type'] = $value;
     
		$this->_location_type = (integer) $value;
		return $this;
	}
     
    /** 1国内，2国外 */ 
	public function getLocation_type(){
        return $this->_location_type;
	}
         
    public function setAdult_oprice($value){
         
        if($value===$this->_adult_oprice) return $this;
        $this->_modified_fields['adult_oprice'] = $value;
     
		$this->_adult_oprice = (string) $value;
		return $this;
	}
     
    /** 成人原价 */ 
	public function getAdult_oprice(){
        return $this->_adult_oprice;
	}
         
    public function setAdult_dprice($value){
         
        if($value===$this->_adult_dprice) return $this;
        $this->_modified_fields['adult_dprice'] = $value;
     
		$this->_adult_dprice = (string) $value;
		return $this;
	}
     
    /** 成人现价 */ 
	public function getAdult_dprice(){
        return $this->_adult_dprice;
	}
         
    public function setChild_oprice($value){
         
        if($value===$this->_child_oprice) return $this;
        $this->_modified_fields['child_oprice'] = $value;
     
		$this->_child_oprice = (string) $value;
		return $this;
	}
     
    /** 儿童原价 */ 
	public function getChild_oprice(){
        return $this->_child_oprice;
	}
         
    public function setChild_dprice($value){
         
        if($value===$this->_child_dprice) return $this;
        $this->_modified_fields['child_dprice'] = $value;
     
		$this->_child_dprice = (string) $value;
		return $this;
	}
     
    /** 儿童现价 */ 
	public function getChild_dprice(){
        return $this->_child_dprice;
	}
         
    public function setArea($value){
         
        if($value===$this->_area) return $this;
        $this->_modified_fields['area'] = $value;
     
		$this->_area = (string) $value;
		return $this;
	}
     
    /** 地区 */ 
	public function getArea(){
        return $this->_area;
	}
         
    public function setSales($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_sales) return $this;
        $this->_modified_fields['sales'] = $value;
     
		$this->_sales = (integer) $value;
		return $this;
	}
     
    /** 已卖票数 */ 
	public function getSales(){
        return $this->_sales;
	}
         
    public function setTitle($value){
         
        if($value===$this->_title) return $this;
        $this->_modified_fields['title'] = $value;
     
		$this->_title = (string) $value;
		return $this;
	}
     
    /** 大标题 */ 
	public function getTitle(){
        return $this->_title;
	}
         
    public function setSubtitle($value){
         
        if($value===$this->_subtitle) return $this;
        $this->_modified_fields['subtitle'] = $value;
     
		$this->_subtitle = (string) $value;
		return $this;
	}
     
    /** 小标题 */ 
	public function getSubtitle(){
        return $this->_subtitle;
	}
         
    public function setImg($value){
         
        if($value===$this->_img) return $this;
        $this->_modified_fields['img'] = $value;
     
		$this->_img = (string) $value;
		return $this;
	}
     
    /** 展示图片 */ 
	public function getImg(){
        return $this->_img;
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
                        'type' =>$this->getType(),
                        'location_type' =>$this->getLocation_type(),
                        'adult_oprice' =>$this->getAdult_oprice(),
                        'adult_dprice' =>$this->getAdult_dprice(),
                        'child_oprice' =>$this->getChild_oprice(),
                        'child_dprice' =>$this->getChild_dprice(),
                        'area' =>$this->getArea(),
                        'sales' =>$this->getSales(),
                        'title' =>$this->getTitle(),
                        'subtitle' =>$this->getSubtitle(),
                        'img' =>$this->getImg(),
                        'ctime' =>$this->getCtime(),
                        'utime' =>$this->getUtime(),
                        'status' =>$this->getStatus(),
                        );
        return $data;
    }
    public function delete(){
        $where = 'id='.$this->getId();
        return Application_Model_M_Travel::delete($where);
    }
}
