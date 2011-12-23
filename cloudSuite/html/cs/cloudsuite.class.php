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
    include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php';}

class cloudsuite {

 
     public static function validate($schema, $file) {

        $doc = new DOMDocument();
        $doc->load($file);

        if ($doc->schemaValidate($schema)) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function getAlltheThings($filename) {

        $xml = simplexml_load_file($filename);
        
        echo "<div> the code!</div><pre>";
        //print_r($xml);
        echo "</pre>";
        
        $result['node'] = $xml->xpath("//node");
        //$result['system_reqs'] = $xml->xpath("module/node/system_reqs/product");
       // $result['foo'] = "BLAH!";
        
        echo "<h1> hope </h1><pre>";
        print_r($result);
         echo "</pre>";
        
     /*
      * $dom = new DOMDocument();
        $dom->loadXML($filename);

        $domlist=$dom->getElementsByTagName('node');
        $sxe=simplexml_import_dom($domlist->item(0));

         echo '\n eh? \n '.$sxe->cannonical_name;
      
        
        echo $xml->module->node->node_name;
       
        foreach ($xml as $key0 => $value) {
      
            echo "..1..[$key0] => $value";
            foreach ($value->attributes() as $attributeskey0 => $attributesvalue1) {
                echo "________[$attributeskey0] = $attributesvalue1";
            }
            echo '<br />';
////////////////////////////////////////////////
            foreach ($value as $key => $value2) {
                echo "....2.....[$key] => $value2";
                foreach ($value2->attributes() as $attributeskey => $attributesvalue2) {
                    echo "________[$attributeskey] = $attributesvalue2";
                }
                echo '<br />';
////////////////////////////////////////////////
                foreach ($value2 as $key2 => $value3) {
                    echo ".........3..........[$key2] => $value3";
                    foreach ($value3->attributes() as $attributeskey2 => $attributesvalue3) {
                        echo "________[$attributeskey2] = $attributesvalue3";
                    }
                    echo '<br />';
////////////////////////////////////////////////
                    foreach ($value3 as $key3 => $value4) {
                        echo "...................4....................[$key3] => $value4";
                        foreach ($value4->attributes() as $attributeskey3 => $attributesvalue4) {
                            echo "________[$attributeskey3] = $attributesvalue4";
                        }
                        echo '<br />';
////////////////////////////////////////////////
                        foreach ($value4 as $key4 => $value5) {
                            echo ".....................5......................[$key4] => $value5";
                            foreach ($value5->attributes() as $attributeskey4 => $attributesvalue5) {
                                echo "________[$attributeskey4] = $attributesvalue5";
                            }
                            echo '<br />';
////////////////////////////////////////////////
                            foreach ($value5 as $key5 => $value6) {
                                echo "......................6.......................[$key5] => $value6";
                                foreach ($value6->attributes() as $attributeskey5 => $attributesvalue6) {
                                    echo "________[$attributeskey5] = $attributesvalue6";
                                }
                                echo '<br />';
                            }
                        }
                    }
                }
            }
            echo '<br />';
        }
        */

        return;
    }

}
class module {
    /* %******************************************************************************************% */

// CORE DEPENDENCIES
// Look for include file in the same directory (e.g. `./config.inc.php`).

    function __construct(){
        
    }
    
    function getOutPut(){
        
    }
    
    function getInputs(){
        
    }
  
}

class set {
    
    private $schema;
    private $set;
    
    function __construct($schema, $xmlFile) {
        $this->schema = $schema;
        $this->set = $xmlFile;
       
        
        }
   
    
    public static function listModules($schema,$xmlFile){
        
        if (!cloudsuite::validate($schema, $xmlFile)){
            echo "ERROR!";
            return;
        }
        
        $xml = simplexml_load_file($xmlFile);
        
        $result = $xml->xpath("//module");
              echo "<h1>";
              echo $result[0]["name"];
              echo "</h1>";
              
              echo "<ol>";
              foreach ($result as $key => $value){
                  
                  echo "<li>";
                  echo "$key =>". $result[$key]["name"]." => ".$result[$key]["id"];
                  echo "</li>";
                  
              }
              echo "</ol>";
              
        print_r($result);
                
        
    }
    
    
}
?>
