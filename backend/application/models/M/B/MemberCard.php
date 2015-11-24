<?php
class Application_Model_M_B_MemberCard extends Application_Model_M_B_Mapper{
   protected static $fields = array ('id'=>'id','name'=>'name','oprice'=>'oprice','dprice'=>'dprice','points'=>'points','ctime'=>'ctime','utime'=>'utime','status'=>'status',);

   public static function setDbTable(){
        global $Application_Model_R_MemberCard;
        if (!$Application_Model_R_MemberCard){
            $Application_Model_R_MemberCard = new Application_Model_R_MemberCard();
        }
        if (!$Application_Model_R_MemberCard instanceof Zend_Db_Table_Abstract){
            throw new Exception('Invalid table data gateway provided');
        }
        return $Application_Model_R_MemberCard;
    }

    public static function getDbTable(){
        global $Application_Model_R_MemberCard;
        if (!$Application_Model_R_MemberCard){
            return self::setDbTable();
        }
        return $Application_Model_R_MemberCard;
    }

    public static function select(){
        return self::getDbTable()->select(true);
    }

    public static function save(Application_Model_O_MemberCard $obj, $extra=''){
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
        $obj = new Application_Model_O_MemberCard();
        $obj
            ->setId($row->id)
            ->setName($row->name)
            ->setOprice($row->oprice)
            ->setDprice($row->dprice)
            ->setPoints($row->points)
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
            $entry = new Application_Model_O_MemberCard();
            $entry
                   ->setId($row->id)
                    ->setName($row->name)
                    ->setOprice($row->oprice)
                    ->setDprice($row->dprice)
                    ->setPoints($row->points)
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
