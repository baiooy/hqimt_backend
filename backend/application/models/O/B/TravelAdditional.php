<?php
class Application_Model_O_B_TravelAdditional extends Application_Model_O_B_Object{
	protected $_mgt='Application_Model_M_TravelAdditional';
    protected $isNew=true;
     
    protected $_id;
     
    /** travelID */ 
    protected $_travel_id;
     
    /** 标题 */ 
    protected $_title;
     
    /** 内容 */ 
    protected $_content;
     
    /** 图片 */ 
    protected $_img;
     
    /** 排序 */ 
    protected $_sort;
     
    /** 1特色，2详情，3费用，4注意事项，5行程 */ 
    protected $_type;
     
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
         
    public function setTravel_id($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_travel_id) return $this;
        $this->_modified_fields['travel_id'] = $value;
     
		$this->_travel_id = (integer) $value;
		return $this;
	}
     
    /** travelID */ 
	public function getTravel_id(){
        return $this->_travel_id;
	}
         
    public function setTitle($value){
         
        if($value===$this->_title) return $this;
        $this->_modified_fields['title'] = $value;
     
		$this->_title = (string) $value;
		return $this;
	}
     
    /** 标题 */ 
	public function getTitle(){
        return $this->_title;
	}
         
    public function setContent($value){
         
        if($value===$this->_content) return $this;
        $this->_modified_fields['content'] = $value;
     
		$this->_content = (string) $value;
		return $this;
	}
     
    /** 内容 */ 
	public function getContent(){
        return $this->_content;
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
         
    public function setType($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_type) return $this;
        $this->_modified_fields['type'] = $value;
     
		$this->_type = (integer) $value;
		return $this;
	}
     
    /** 1特色，2详情，3费用，4注意事项，5行程 */ 
	public function getType(){
        return $this->_type;
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
                        'travel_id' =>$this->getTravel_id(),
                        'title' =>$this->getTitle(),
                        'content' =>$this->getContent(),
                        'img' =>$this->getImg(),
                        'sort' =>$this->getSort(),
                        'type' =>$this->getType(),
                        'ctime' =>$this->getCtime(),
                        'utime' =>$this->getUtime(),
                        'status' =>$this->getStatus(),
                        );
        return $data;
    }
    public function delete(){
        $where = 'id='.$this->getId();
        return Application_Model_M_TravelAdditional::delete($where);
    }
}
