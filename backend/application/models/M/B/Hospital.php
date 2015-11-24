<?php
class Application_Model_M_B_Hospital extends Application_Model_M_B_Mapper{
   protected static $fields = array ('id'=>'id','name'=>'name','avatar'=>'avatar','email'=>'email','departments'=>'departments','type'=>'type','certified'=>'certified','city'=>'city','label'=>'label','country'=>'country','point'=>'point','area'=>'area','passwd'=>'passwd','phone'=>'phone','introduction'=>'introduction','longitude'=>'longitude','latitude'=>'latitude','ctime'=>'ctime','utime'=>'utime','status'=>'status',);

   public static function setDbTable(){
        global $Application_Model_R_Hospital;
        if (!$Application_Model_R_Hospital){
            $Application_Model_R_Hospital = new Application_Model_R_Hospital();
        }
        if (!$Application_Model_R_Hospital instanceof Zend_Db_Table_Abstract){
            throw new Exception('Invalid table data gateway provided');
        }
        return $Application_Model_R_Hospital;
    }

    public static function getDbTable(){
        global $Application_Model_R_Hospital;
        if (!$Application_Model_R_Hospital){
            return self::setDbTable();
        }
        return $Application_Model_R_Hospital;
    }

    public static function select(){
        return self::getDbTable()->select(true);
    }

    public static function save(Application_Model_O_Hospital $obj, $extra=''){
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
        $obj = new Application_Model_O_Hospital();
        $obj
            ->setId($row->id)
            ->setName($row->name)
            ->setAvatar($row->avatar)
            ->setEmail($row->email)
            ->setDepartments($row->departments)
            ->setType($row->type)
            ->setCertified($row->certified)
            ->setCity($row->city)
            ->setLabel($row->label)
            ->setCountry($row->country)
            ->setPoint($row->point)
            ->setArea($row->area)
            ->setPasswd($row->passwd)
            ->setPhone($row->phone)
            ->setIntroduction($row->introduction)
            ->setLongitude($row->longitude)
            ->setLatitude($row->latitude)
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
            $entry = new Application_Model_O_Hospital();
            $entry
                   ->setId($row->id)
                    ->setName($row->name)
                    ->setAvatar($row->avatar)
                    ->setEmail($row->email)
                    ->setDepartments($row->departments)
                    ->setType($row->type)
                    ->setCertified($row->certified)
                    ->setCity($row->city)
                    ->setLabel($row->label)
                    ->setCountry($row->country)
                    ->setPoint($row->point)
                    ->setArea($row->area)
                    ->setPasswd($row->passwd)
                    ->setPhone($row->phone)
                    ->setIntroduction($row->introduction)
                    ->setLongitude($row->longitude)
                    ->setLatitude($row->latitude)
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
