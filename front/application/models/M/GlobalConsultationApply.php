<?php

class Application_Model_M_GlobalConsultationApply extends Application_Model_M_B_GlobalConsultationApply{
    public static function updateReport($id,$img){
    	$sql = "UPDATE yy_global_consultation_apply SET report = '{$img}' WHERE id = {$id}";
    	$config = self::getDb()->getConfig();
    	$pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
    	return $pdo->exec($sql);
    }
    public static function getReport($id){
    	$sql = "SELECT report FROM yy_global_consultation_apply WHERE id={$id}";
    	$res = self::getDb()->query($sql)->fetchAll();
    	$img = "";
    	if(count($res)>0){
    		$img = $res['0']['report'];
    	}
    	return $img;
    }
}