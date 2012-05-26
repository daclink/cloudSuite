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
    
    private $users = array('1' => 'Drew',
                           '2' => 'Gabbo',
                           '3' => 'Jenny',
                           '4' => 'AJ');

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
    
    public static function login ($uname, $pass, $id=NULL) {
        
        $users = array('Drew'  => 'drew',
                       'Gabbo' => 'gabbo',
                       'Jenny' => 'penny',
                       'AJ'    => 'aj');
        

        if ($users[$uname] === $pass){
          if (!isset($_SESSION)) {
             session_start();
            }
            
            $_SESSION['cs']['username'] = $uname;
            $_ENV['cs']['username'] = $uname;
            setcookie('cs_uname',$uname);
            return 1;
           // return array ($id => $name);
        }
        
        return false;
    }
    
    public static function logout () {
        if (isset($_SESSION['cs']['username'])){
            unset($_SESSION['cs']);
        }
        if (isset($_COOKIE['cs_uname'])){
            unset($$_COOKIE['cs_uname']);
        }
        
    }
}


?>
