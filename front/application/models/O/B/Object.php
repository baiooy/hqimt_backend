<?php
class Application_Model_O_B_Object
{

    protected $_mgt;
    protected $_modified_fields;
    
    public function __construct(){
        ;
    }

    public function save()
    {
        $result = call_user_func("$this->_mgt::save", $this);
        if (!$this->getId()) {
            $this->setId($result);
        }
        return $result;
    }

    public function getModifiedFields()
    {
        return $this->_modified_fields;
    }
	
    public function emptyModefiedFields()
    {
    	$this->_modified_fields = array();
    }
}





// public function __set($name, $value){
// 	$method = 'set' . $name;
// 	if (method_exists($this, $method)) {
// 		$this->$method($value);
// 	}
// }

// public function __get($name){
// 	$method = 'get' . $name;
// 	if ($name == 'array') {
// 		$method = 'toArray';
// 	}
// 	if (('mapper' == $name) || !method_exists($this, $method)) {
// 		return null;
// 	}
// 	return $this->$method();
// }

// public function getId()
// {
// 	return $this->id;
// }

// public function setId($id)
// {
// 	$this->id = $id;
// }

// public function setOptions(array $options)
// {
// 	$methods = get_class_methods($this);
// 	foreach ($options as $key => $value) {
// 		$method = 'set' . ucfirst($key);
// 		if (in_array($method, $methods)) {
// 			echo $method . "\n";
// 			$this->$method($value);
// 		}
// 	}
// 	return $this;
// }
// public static function handleArray(&$arr)
// {
// 	foreach ($arr as $key => $value) {
// 		if ($str = strstr($key, '.')) {
// 			$arr[substr($str, 1)] = $value;
// 		} else {
// 			$arr[$key] = $value;
// 		}
// 	};
// }

// public function removeEmpty($arr)
// {
// 	foreach ($arr as $key => $value) {
// 		if ($value === null) {
// 			unset($arr[$key]);
// 		}
// 	};
// 	return $arr;
// }