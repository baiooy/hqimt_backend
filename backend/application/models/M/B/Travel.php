<?php
class Application_Model_M_B_Travel extends Application_Model_M_B_Mapper{
   protected static $fields = array ('id'=>'id','type'=>'type','location_type'=>'location_type','adult_oprice'=>'adult_oprice','adult_dprice'=>'adult_dprice','child_oprice'=>'child_oprice','child_dprice'=>'child_dprice','area'=>'area','sales'=>'sales','title'=>'title','subtitle'=>'subtitle','img'=>'img','ctime'=>'ctime','utime'=>'utime','status'=>'status',);

   public static function setDbTable(){
        global $Application_Model_R_Travel;
        if (!$Application_Model_R_Travel){
            $Application_Model_R_Travel = new Application_Model_R_Travel();
        }
        if (!$Application_Model_R_Travel instanceof Zend_Db_Table_Abstract){
            throw new Exception('Invalid table data gateway provided');
        }
        return $Application_Model_R_Travel;
    }

    public static function getDbTable(){
        global $Application_Model_R_Travel;
        if (!$Application_Model_R_Travel){
            return self::setDbTable();
        }
        return $Application_Model_R_Travel;
    }

    public static function select(){
        return self::getDbTable()->select(true);
    }

    public static function save(Application_Model_O_Travel $obj, $extra=''){
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
        $obj = new Application_Model_O_Travel();
        $obj
            ->setId($row->id)
            ->setType($row->type)
            ->setLocation_type($row->location_type)
            ->setAdult_oprice($row->adult_oprice)
            ->setAdult_dprice($row->adult_dprice)
            ->setChild_oprice($row->child_oprice)
            ->setChild_dprice($row->child_dprice)
            ->setArea($row->area)
            ->setSales($row->sales)
            ->setTitle($row->title)
            ->setSubtitle($row->subtitle)
            ->setImg($row->img)
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
            $entry = new Application_Model_O_Travel();
            $entry
                   ->setId($row->id)
                    ->setType($row->type)
                    ->setLocation_type($row->location_type)
                    ->setAdult_oprice($row->adult_oprice)
                    ->setAdult_dprice($row->adult_dprice)
                    ->setChild_oprice($row->child_oprice)
                    ->setChild_dprice($row->child_dprice)
                    ->setArea($row->area)
                    ->setSales($row->sales)
                    ->setTitle($row->title)
                    ->setSubtitle($row->subtitle)
                    ->setImg($row->img)
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
