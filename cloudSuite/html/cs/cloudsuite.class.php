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
if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php')) {
    include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php';
}

/**
 * CloudSuite: General functions and utilities.
 */
class CloudSuite {

    public static function validate($schema, $file) {

        $doc = new DOMDocument();
        $doc->load($file);

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

    function __construct() {
        
    }

    function getOutPut() {
        
    }

    function getInputs() {
        
    }

}

class set {

    private $schema;
    private $set;

    function __construct($schema, $xmlFile) {
        $this->schema = $schema;
        $this->set = $xmlFile;
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

?>
