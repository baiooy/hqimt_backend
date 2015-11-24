<?php
class Application_Model_M_B_Doctor extends Application_Model_M_B_Mapper{
   protected static $fields = array ('id'=>'id','name'=>'name','avatar'=>'avatar','sex'=>'sex','birthday'=>'birthday','email'=>'email','passwd'=>'passwd','phone'=>'phone','department'=>'department','point'=>'point','city'=>'city','certified'=>'certified','special'=>'special','country'=>'country','introduction'=>'introduction','hospital'=>'hospital','area'=>'area','qualification'=>'qualification','reservation_fee'=>'reservation_fee','reservation_number'=>'reservation_number','ctime'=>'ctime','utime'=>'utime','status'=>'status',);

   public static function setDbTable(){
        global $Application_Model_R_Doctor;
        if (!$Application_Model_R_Doctor){
            $Application_Model_R_Doctor = new Application_Model_R_Doctor();
        }
        if (!$Application_Model_R_Doctor instanceof Zend_Db_Table_Abstract){
            throw new Exception('Invalid table data gateway provided');
        }
        return $Application_Model_R_Doctor;
    }

    public static function getDbTable(){
        global $Application_Model_R_Doctor;
        if (!$Application_Model_R_Doctor){
            return self::setDbTable();
        }
        return $Application_Model_R_Doctor;
    }

    public static function select(){
        return self::getDbTable()->select(true);
    }

    public static function save(Application_Model_O_Doctor $obj, $extra=''){
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
        $obj = new Application_Model_O_Doctor();
        $obj
            ->setId($row->id)
            ->setName($row->name)
            ->setAvatar($row->avatar)
            ->setSex($row->sex)
            ->setBirthday($row->birthday)
            ->setEmail($row->email)
            ->setPasswd($row->passwd)
            ->setPhone($row->phone)
            ->setDepartment($row->department)
            ->setPoint($row->point)
            ->setCity($row->city)
            ->setCertified($row->certified)
            ->setSpecial($row->special)
            ->setCountry($row->country)
            ->setIntroduction($row->introduction)
            ->setHospital($row->hospital)
            ->setArea($row->area)
            ->setQualification($row->qualification)
            ->setReservation_fee($row->reservation_fee)
            ->setReservation_number($row->reservation_number)
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
            $entry = new Application_Model_O_Doctor();
            $entry
                   ->setId($row->id)
                    ->setName($row->name)
                    ->setAvatar($row->avatar)
                    ->setSex($row->sex)
                    ->setBirthday($row->birthday)
                    ->setEmail($row->email)
                    ->setPasswd($row->passwd)
                    ->setPhone($row->phone)
                    ->setDepartment($row->department)
                    ->setPoint($row->point)
                    ->setCity($row->city)
                    ->setCertified($row->certified)
                    ->setSpecial($row->special)
                    ->setCountry($row->country)
                    ->setIntroduction($row->introduction)
                    ->setHospital($row->hospital)
                    ->setArea($row->area)
                    ->setQualification($row->qualification)
                    ->setReservation_fee($row->reservation_fee)
                    ->setReservation_number($row->reservation_number)
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
