<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cloudsuite
 *
 * @author drew
 */
if (file_exists(dirname(__FILE__) . 
                DIRECTORY_SEPARATOR . 'config.php')) {
    include_once dirname(__FILE__) . 
                 DIRECTORY_SEPARATOR . 'config.php';
}

class Exceptions {
    
    private $data = array(
                'M_NO_ELEMENT' => 'No Such Element in data definition',
                'C_NO_ELEMENT' => 0
                        )
        ;
    public static function __get($name){
        if (array_key_exists($name, $this->data)){
                return $this->data[$name];
            }else {
                return '404';
            }
        
    }
}

/**
 * CloudSuite: General functions and utilities.
 */
class CloudSuite {

    public static function validate($schema, $xmlFile) {

        $doc = new DOMDocument();
        $doc->load($xmlFile);

        if ($doc->schemaValidate($schema)) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function load_xml($xmlSchema, $xmlFile, &$xml){
        if (!CloudSuite::validate($xmlSchema, $xmlFile)) {
            
            return false;
        }
        $xml = simplexml_load_file($xmlFile);
        return true;
    }
    
/**
 *The following was found at http://www.php.net/manual/en/book.array.php
 * @param type $item
 * @param type $key
 * @param string $array_name 
 * 
 * produces a javascript array
 * 
 */    
    public static function array_print($item, $key, $array_name) 
    {
        if(is_array($item)){
            $array_name = $array_name."['".$key."']";
            echo $array_name ."= Array();". "";
            php_array_to_js_array($item, $array_name);
        }else{
            echo $array_name."['".$key."'] = \"".$item."\";";
        }
    }

    public static function php_array_to_js_array($array, $array_name){
        array_walk($array, 'array_print', $array_name);
     }
}


class module {
    /* %******************************************************************************************% */

// CORE DEPENDENCIES
// Look for include file in the same directory (e.g. `./config.inc.php`).
    
    private $schema;
    private $xmlFile;
    
    private $data = array('id'          =>  '',
                          'name'        =>  '',
                          'parameters'  =>  array(''),
                          'outputs'     =>  array(''),
                          'inputs'      =>  array(''));
    
    
    function __construct($schema, $xmlFile) {
        
        $this->schema = $schema;
        $this->xmlFile = $xmlFile;
        
        if(!CloudSuite::load_xml($schema, $xmlFile, $xml)){
            return false;
        }
        
        $this->data['id']           
                   = $xml->xpath("//module");
        $this->data['name']
                   = $xml->xpath("name");
        $this->data['parameters']
                   = $xml->xpath("parameters");
        $this->data['inputs'] 
                   = $xml->xpath("inputs");
                   
        return true;
    }

    function __destruct(){
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }
    
    function __get($name) {
        if (array_key_exists($name, $this->data)){
            return $this->data[$name];
        } else {
            throw new Exception('No Such Element','0');
            return FALSE;
        }
    }

    function __set($name, $value) {
        
    }
    
    
    
}

class set {

    private $schema;
    private $xmlFile;

    private $data = array('id'        => '',
                          'name'      => '',
                          'fname'     => '',
                          'lname'     => '',
                          'clearance' => '');
    
    function __set($name, $value){
        if (array_key_exists($name, $this->data)){
            $this->data[$name] = $value;
            return true;
        } else {
            throw new Exception('No Such Element','0');
            return FALSE;
        }
    }
    
    function __get($name){
        if (array_key_exists($name, $this->data)){
            return $this->data[$name];
        } else {
            throw new Exception('No Such Element','0');
            return FALSE;
        }
    }
    
    function __construct($schema, $xmlFile) {
        $this->schema   = $schema;
        $this->xmlFile  = $xmlFile;
    }
    
    function __destruct(){
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    public static function listModules($schema, $xmlFile) {

        $ret = array();
        
        if(!CloudSuite::load_xml($schema, $xmlFile, $xml)){
            return false;
        }
        $result = $xml->xpath("//module");

        foreach ($result as $key => $value) {
            
            $id   = intval((string)$result[$key]["id"]);
            $name = (string)$result[$key]["name"];
            $ret[$id] = $name;
        }
            
        return $ret;
            
    }
    
}

class lab {
    
    private $data = array('sets'      => '',
                          'modules'   => '',
                          'user'      => '');
    
    function __set($name, $value){
        if (array_key_exists($name, $this->data)){
            $this->data[$name] = $value;
            return true;
        } else {
            throw new Exception('No Such Element','0');
            return FALSE;
        }
    }
    
    function __get($name){
        if (array_key_exists($name, $this->data)){
            return $this->data[$name];
        } else {
            throw new Exception('No Such Element','0');
            return FALSE;
        }
    }
    
    /*
    function __construct($user) {
        $this->__user = $user;
    }
    
    function writeLab(){
        
    }
    
    function readLab(){
        
    }
    
    function getSets(){
        
    }
    
    function getSets() {
        return $this->__sets;
    }
    
    function getModules() {
        return $this->__modules;
    }
    */
}

class user {
    
  /*
    private $__id;
    private $__name;
    private $__fname;
    private $__lname;
    private $__clearance;
  */
    private $data = array('id'        => '',
                          'name'      => '',
                          'fname'     => '',
                          'lname'     => '',
                          'clearance' => '');
    
    function __set($name, $value){
        if (array_key_exists($name, $this->data)){
            $this->data[$name] = $value;
            return true;
        } else {
            throw new Exception('No Such Element','0');
            return FALSE;
        }
    }
    
    function __get($name){
        if (array_key_exists($name, $this->data)){
            return $this->data[$name];
        } else {
            throw new Exception('No Such Element','0');
            return FALSE;
        }
    }
    
}

?>