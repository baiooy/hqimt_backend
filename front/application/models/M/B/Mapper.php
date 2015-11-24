<?php
class Application_Model_M_B_Mapper
{
    public static function getDb(){
        return Zend_Db_Table::getDefaultAdapter();
    }

}