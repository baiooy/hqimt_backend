<?php
class Application_Model_M_B_GlobalConsultationApply extends Application_Model_M_B_Mapper{
   protected static $fields = array ('id'=>'id','department_category_id'=>'department_category_id','department_id'=>'department_id','email'=>'email','mobile'=>'mobile','age'=>'age','sex'=>'sex','location'=>'location','treatment_time'=>'treatment_time','opinion'=>'opinion','report'=>'report','ctime'=>'ctime','utime'=>'utime','status'=>'status',);

   public static function setDbTable(){
        global $Application_Model_R_GlobalConsultationApply;
        if (!$Application_Model_R_GlobalConsultationApply){
            $Application_Model_R_GlobalConsultationApply = new Application_Model_R_GlobalConsultationApply();
        }
        if (!$Application_Model_R_GlobalConsultationApply instanceof Zend_Db_Table_Abstract){
            throw new Exception('Invalid table data gateway provided');
        }
        return $Application_Model_R_GlobalConsultationApply;
    }

    public static function getDbTable(){
        global $Application_Model_R_GlobalConsultationApply;
        if (!$Application_Model_R_GlobalConsultationApply){
            return self::setDbTable();
        }
        return $Application_Model_R_GlobalConsultationApply;
    }

    public static function select(){
        return self::getDbTable()->select(true);
    }

    public static function save(Application_Model_O_GlobalConsultationApply $obj, $extra=''){
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
        $obj = new Application_Model_O_GlobalConsultationApply();
        $obj
            ->setId($row->id)
            ->setDepartment_category_id($row->department_category_id)
            ->setDepartment_id($row->department_id)
            ->setEmail($row->email)
            ->setMobile($row->mobile)
            ->setAge($row->age)
            ->setSex($row->sex)
            ->setLocation($row->location)
            ->setTreatment_time($row->treatment_time)
            ->setOpinion($row->opinion)
            ->setReport($row->report)
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
            $entry = new Application_Model_O_GlobalConsultationApply();
            $entry
                   ->setId($row->id)
                    ->setDepartment_category_id($row->department_category_id)
                    ->setDepartment_id($row->department_id)
                    ->setEmail($row->email)
                    ->setMobile($row->mobile)
                    ->setAge($row->age)
                    ->setSex($row->sex)
                    ->setLocation($row->location)
                    ->setTreatment_time($row->treatment_time)
                    ->setOpinion($row->opinion)
                    ->setReport($row->report)
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
