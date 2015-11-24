<?php
class Application_Model_O_B_TravelOrder extends Application_Model_O_B_Object{
	protected $_mgt='Application_Model_M_TravelOrder';
    protected $isNew=true;
     
    protected $_id;
     
    /** 订单号 */ 
    protected $_order_id;
     
    /** 该订单所属的用户id */ 
    protected $_uid;
     
    /** 1普通用户，2医生用户，3医院用户 */ 
    protected $_urole;
     
    /** travelID */ 
    protected $_travel_id;
     
    /** 成人票数 */ 
    protected $_adult_ticket_number;
     
    /** 儿童票数 */ 
    protected $_child_ticket_number;
     
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
     
    /** 订单号 */ 
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
         
    public function setAdult_ticket_number($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_adult_ticket_number) return $this;
        $this->_modified_fields['adult_ticket_number'] = $value;
     
		$this->_adult_ticket_number = (integer) $value;
		return $this;
	}
     
    /** 成人票数 */ 
	public function getAdult_ticket_number(){
        return $this->_adult_ticket_number;
	}
         
    public function setChild_ticket_number($value){
         
        $value = $value ? (integer) $value : $value;
     
        if($value===$this->_child_ticket_number) return $this;
        $this->_modified_fields['child_ticket_number'] = $value;
     
		$this->_child_ticket_number = (integer) $value;
		return $this;
	}
     
    /** 儿童票数 */ 
	public function getChild_ticket_number(){
        return $this->_child_ticket_number;
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
                        'travel_id' =>$this->getTravel_id(),
                        'adult_ticket_number' =>$this->getAdult_ticket_number(),
                        'child_ticket_number' =>$this->getChild_ticket_number(),
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
        return Application_Model_M_TravelOrder::delete($where);
    }
}
