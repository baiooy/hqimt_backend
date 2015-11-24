<?php
class Application_Model_O_B_ConsultOrder extends Application_Model_O_B_Object{
	protected $_mgt='Application_Model_M_ConsultOrder';
    protected $isNew=true;
     
    protected $_id;
     
    protected $_order_id;
     
    /** 该订单所属的用户id */ 
    protected $_uid;
     
    /** 1普通用户，2医生用户，3医院用户 */ 
    protected $_urole;
     
    /** 被预约医生,doctorID */ 
    protected $_todid;
     
    /** 总价 */ 
    protected $_total_price;
     
    /** 支付状态，0未支付，1已支付 */ 
    protected $_payment_status;
     
    /** 支付信息 */ 
    protected $_remark;
     
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
         
    public function setOrder_id($value){
         
        if($value===$this->_order_id) return $this;
        $this->_modified_fields['order_id'] = $value;
     
		$this->_order_id = (string) $value;
		return $this;
	}
     
	public function getOrder_id(){
        return $this->_order_id;
	}
         
    public function setUid($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_uid) return $this;
        $this->_modified_fields['uid'] = $value;
     
		$this->_uid = (integer) $value;
		return $this;
	}
     
    /** 该订单所属的用户id */ 
	public function getUid(){
        return $this->_uid;
	}
         
    public function setUrole($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_urole) return $this;
        $this->_modified_fields['urole'] = $value;
     
		$this->_urole = (integer) $value;
		return $this;
	}
     
    /** 1普通用户，2医生用户，3医院用户 */ 
	public function getUrole(){
        return $this->_urole;
	}
         
    public function setTodid($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_todid) return $this;
        $this->_modified_fields['todid'] = $value;
     
		$this->_todid = (integer) $value;
		return $this;
	}
     
    /** 被预约医生,doctorID */ 
	public function getTodid(){
        return $this->_todid;
	}
         
    public function setTotal_price($value){
         
        if($value===$this->_total_price) return $this;
        $this->_modified_fields['total_price'] = $value;
     
		$this->_total_price = (string) $value;
		return $this;
	}
     
    /** 总价 */ 
	public function getTotal_price(){
        return $this->_total_price;
	}
         
    public function setPayment_status($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_payment_status) return $this;
        $this->_modified_fields['payment_status'] = $value;
     
		$this->_payment_status = (integer) $value;
		return $this;
	}
     
    /** 支付状态，0未支付，1已支付 */ 
	public function getPayment_status(){
        return $this->_payment_status;
	}
         
    public function setRemark($value){
         
        if($value===$this->_remark) return $this;
        $this->_modified_fields['remark'] = $value;
     
		$this->_remark = (string) $value;
		return $this;
	}
     
    /** 支付信息 */ 
	public function getRemark(){
        return $this->_remark;
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
                        'order_id' =>$this->getOrder_id(),
                        'uid' =>$this->getUid(),
                        'urole' =>$this->getUrole(),
                        'todid' =>$this->getTodid(),
                        'total_price' =>$this->getTotal_price(),
                        'payment_status' =>$this->getPayment_status(),
                        'remark' =>$this->getRemark(),
                        'ctime' =>$this->getCtime(),
                        'utime' =>$this->getUtime(),
                        'status' =>$this->getStatus(),
                        );
        return $data;
    }
    public function delete(){
        $where = 'id='.$this->getId();
        return Application_Model_M_ConsultOrder::delete($where);
    }
}
