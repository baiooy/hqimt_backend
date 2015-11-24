<?php
class Application_Model_M_B_ReservationOrder extends Application_Model_M_B_Mapper{
   protected static $fields = array ('id'=>'id','order_id'=>'order_id','uid'=>'uid','urole'=>'urole','from'=>'from','from_role'=>'from_role','to'=>'to','total_price'=>'total_price','payment_status'=>'payment_status','ctime'=>'ctime','utime'=>'utime','status'=>'status',);

   public static function setDbTable(){
        global $Application_Model_R_ReservationOrder;
        if (!$Application_Model_R_ReservationOrder){
            $Application_Model_R_ReservationOrder = new Application_Model_R_ReservationOrder();
        }
        if (!$Application_Model_R_ReservationOrder instanceof Zend_Db_Table_Abstract){
            throw new Exception('Invalid table data gateway provided');
        }
        return $Application_Model_R_ReservationOrder;
    }

    public static function getDbTable(){
        global $Application_Model_R_ReservationOrder;
        if (!$Application_Model_R_ReservationOrder){
            return self::setDbTable();
        }
        return $Application_Model_R_ReservationOrder;
    }

    public static function select(){
        return self::getDbTable()->select(true);
    }

    public static function save(Application_Model_O_ReservationOrder $obj, $extra=''){
        if(!$obj->getModifiedFields()) return $obj;
        foreach ($obj->getModifiedFields() as $key=>$value) {
            $field=self::$fields[strtolower($key)];
            if($field){
                $data[$field]=$value;
            }
        }
        if (!$obj->getId()){
            $obj->setId(self::getDbTable()->insert($data, $extra));
            $obj->setNew(false);
        }else{
            self::getDbTable()->update($data, array('id = ?' => $obj->getId()));
        }
        return $obj;
    }

    public static function find($id){
        $result = self::getDbTable()->find($id);
        if (0 == count($result))
        {
            return;
        }
        $row = $result->current();
        $obj = new Application_Model_O_ReservationOrder();
        $obj
            ->setId($row->id)
            ->setOrder_id($row->order_id)
            ->setUid($row->uid)
            ->setUrole($row->urole)
            ->setFrom($row->from)
            ->setFrom_role($row->from_role)
            ->setTo($row->to)
            ->setTotal_price($row->total_price)
            ->setPayment_status($row->payment_status)
            ->setCtime($row->ctime)
            ->setUtime($row->utime)
            ->setStatus($row->status)
                    ;
        $obj->setNew(false);
        return $obj;
    }

    public static function fetchAll($where=null, $order=null, $limit=null, $offset=null){
        $resultSet = self::getDbTable()->fetchAll($where, $order, $limit, $offset);
        $entries = array();
        foreach ($resultSet as $row){
            $entry = new Application_Model_O_ReservationOrder();
            $entry
                   ->setId($row->id)
                    ->setOrder_id($row->order_id)
                    ->setUid($row->uid)
                    ->setUrole($row->urole)
                    ->setFrom($row->from)
                    ->setFrom_role($row->from_role)
                    ->setTo($row->to)
                    ->setTotal_price($row->total_price)
                    ->setPayment_status($row->payment_status)
                    ->setCtime($row->ctime)
                    ->setUtime($row->utime)
                    ->setStatus($row->status)
                                ;
            $entry->setNew(false);
            $entries[] = $entry;
        }
        return $entries;
    }

    public static function delete($where){
        return self::getDbTable()->delete($where);
    }

}