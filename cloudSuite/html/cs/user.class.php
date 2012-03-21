<?php
/**
 * Description of user
 *
 * @author Drew A. Clinkenbeard
 */

class User {
    /*
      private $__id;
      private $__name;
      private $__fname;
      private $__lname;
      private $__clearance;
     */

    private $data = array('id' => '',
        'name' => '',
        'fname' => '',
        'lname' => '',
        'clearance' => '');

    function __set($name, $value) {
        if (array_key_exists($name, $this->data)) {
            $this->data[$name] = $value;
            return true;
        } else {
            throw new Exception('No Such Element', '0');
            return FALSE;
        }
    }

    function __get($name) {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        } else {
            throw new Exception('No Such Element', '0');
            return FALSE;
        }
        
    }
    
    function __construct() {
        $this->data['id'] = Utils::genID();
    }

    function __destruct() {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }
}


?>
