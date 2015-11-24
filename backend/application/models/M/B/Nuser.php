<?php
class Application_Model_M_B_Nuser extends Application_Model_M_B_Mapper{
   protected static $fields = array ('id'=>'id','mobile'=>'mobile','email'=>'email','phone'=>'phone','passwd'=>'passwd','name'=>'name','avatar'=>'avatar','sex'=>'sex','job'=>'job','postcode'=>'postcode','idcard'=>'idcard','point'=>'point','country'=>'country','address'=>'address','birthday'=>'birthday','ctime'=>'ctime','utime'=>'utime','status'=>'status',);

   public static function setDbTable(){
        global $Application_Model_R_Nuser;
        if (!$Application_Model_R_Nuser){
            $Application_Model_R_Nuser = new Application_Model_R_Nuser();
        }
        if (!$Application_Model_R_Nuser instanceof Zend_Db_Table_Abstract){
            throw new Exception('Invalid table data gateway provided');
        }
        return $Application_Model_R_Nuser;
    }

    public static function getDbTable(){
        global $Application_Model_R_Nuser;
        if (!$Application_Model_R_Nuser){
            return self::setDbTable();
        }
        return $Application_Model_R_Nuser;
    }

    public static function select(){
        return self::getDbTable()->select(true);
    }

    public static function save(Application_Model_O_Nuser $obj, $extra=''){
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
        $obj = new Application_Model_O_Nuser();
        $obj
            ->setId($row->id)
            ->setMobile($row->mobile)
            ->setEmail($row->email)
            ->setPhone($row->phone)
            ->setPasswd($row->passwd)
            ->setName($row->name)
            ->setAvatar($row->avatar)
            ->setSex($row->sex)
            ->setJob($row->job)
            ->setPostcode($row->postcode)
            ->setIdcard($row->idcard)
            ->setPoint($row->point)
            ->setCountry($row->country)
            ->setAddress($row->address)
            ->setBirthday($row->birthday)
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
            $entry = new Application_Model_O_Nuser();
            $entry
                   ->setId($row->id)
                    ->setMobile($row->mobile)
                    ->setEmail($row->email)
                    ->setPhone($row->phone)
                    ->setPasswd($row->passwd)
                    ->setName($row->name)
                    ->setAvatar($row->avatar)
                    ->setSex($row->sex)
                    ->setJob($row->job)
                    ->setPostcode($row->postcode)
                    ->setIdcard($row->idcard)
                    ->setPoint($row->point)
                    ->setCountry($row->country)
                    ->setAddress($row->address)
                    ->setBirthday($row->birthday)
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
