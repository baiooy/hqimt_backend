<?php
class Application_Model_O_B_Banner extends Application_Model_O_B_Object{
	protected $_mgt='Application_Model_M_Banner';
    protected $isNew=true;
     
    protected $_id;
     
    /** 显示文字 */ 
    protected $_title;
     
    /** 广告内容 */ 
    protected $_content;
     
    /** 跳转URL */ 
    protected $_link;
     
    /** 广告对应的图片 */ 
    protected $_img;
     
    /** 排序 */ 
    protected $_sort;
     
    /** 创建时间 */ 
    protected $_ctime;
     
    /** 更新时间 */ 
    protected $_utime;
     
    /** 是否显示，1显示，0不显示 */ 
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
         
    public function setTitle($value){
         
        if($value===$this->_title) return $this;
        $this->_modified_fields['title'] = $value;
     
		$this->_title = (string) $value;
		return $this;
	}
     
    /** 显示文字 */ 
	public function getTitle(){
        return $this->_title;
	}
         
    public function setContent($value){
         
        if($value===$this->_content) return $this;
        $this->_modified_fields['content'] = $value;
     
		$this->_content = (string) $value;
		return $this;
	}
     
    /** 广告内容 */ 
	public function getContent(){
        return $this->_content;
	}
         
    public function setLink($value){
         
        if($value===$this->_link) return $this;
        $this->_modified_fields['link'] = $value;
     
		$this->_link = (string) $value;
		return $this;
	}
     
    /** 跳转URL */ 
	public function getLink(){
        return $this->_link;
	}
         
    public function setImg($value){
         
        if($value===$this->_img) return $this;
        $this->_modified_fields['img'] = $value;
     
		$this->_img = (string) $value;
		return $this;
	}
     
    /** 广告对应的图片 */ 
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
     
    /** 是否显示，1显示，0不显示 */ 
	public function getStatus(){
        return $this->_status===null?1:$this->_status;
	}
    
    public function toArray(){
         $data = array(
                'id' => $this->getId(),
                        'title' =>$this->getTitle(),
                        'content' =>$this->getContent(),
                        'link' =>$this->getLink(),
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
        return Application_Model_M_Banner::delete($where);
    }
}
