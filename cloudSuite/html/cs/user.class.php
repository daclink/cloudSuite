<?php
/**
 * Description of user
 *
 * @author Drew A. Clinkenbeard
 */

class User {
    
      private $__id;
      private $__uname;
      private $__fname;
      private $__lname;
      private $__clearance;
      private $__displayName;
    
    
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
    
    function __construct($uname, $password, $id=NULL, $xmlFile = NULL, $schema = NULL ) {
        
        if ( $schema != NULL ) {
            $this->schema = $schema;
        } else {
            $this->schema = $_ENV['cs']['schema_dir'] . "user.xsd";
        }
        
        if ( $xmlFile != NULL ) {
            $this->xml = $xmlFile;
            Utils::load_xml( $schema, $xmlFile, $xml );
            User::loadUser($xml);
            return;
        } 
        
        $this->id = Utils::genID();
        $this->uname = $uname;
        
        $user = new SimpleXMLElement('<user></user>');
        $user->addAttribute('id', $this->id);
        
        $user->addChild("userName", $uname);
        $user->addChild("displayName", $uname);
        $user->addChild("firstName");
        $user->addChild("lastName");
        $user->addChild("password", $password);
        $user->addChild("clearance");
        
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
      try {  
          
          if (isset($_SESSION['cs']['username'])){
              unset($_SESSION['cs']);
          }
          if (isset($_COOKIE['cs_uname'])){
            unset($$_COOKIE['cs_uname']);
          }
          
          return true;
          
      } catch (Exception $e) {
          return false;
      }
    }
    
    public static function loadUser(SimpleXMLElement $xml) {
        
    }
    
    public function getUname(){
        return $this->__uname;
    }
    
    public function getFname(){
        return $this->__fname;
    }
    
    public function getLname(){
        return $this->__lname;
    }
    
    public function getClearance(){
        return $this->__clearance;
    }
    
    public function setUname (String $uname) {
        $this->uname = $uname;
        return true;
    }
    
    public function setFname (String $fname) {
        $this->fname = $fname;
        return true;
    }
    
    public function setLname(String $lname) {
        $this->__lname = $lname;
        return true;
    }
    
    public function setClearance ( int $level) {
        if ($level > 10 || $level < 0 ) {
            throw new ErrorException("Level must be between 0 and 10", 1);
            return false;
        }
        
        $this->__clearance = $level;
    }
    
}


?>
