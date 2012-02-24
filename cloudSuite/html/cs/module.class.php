<?php
/**
*@author Drew A. Clinkenbeard
*CloudSuite module class.
*/
class module {
    /* %******************************************************************************************% */

// CORE DEPENDENCIES
// Look for include file in the same directory (e.g. `./config.inc.php`).

    private $__moduleSchema;
    private $__moduleXmlFile;
    private $__data = array('id' => '',
        'name' => '',
        'parameters' => array(''),
        'outputs' => array(''),
        'inputs' => array(''),
        'sequenceNumber' => '-1');

    function __construct($schema, $xmlFile) {

    }
        
     

    function __destruct() {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    function __get($name) {
        if (array_key_exists($name, $this->__data)) {
            return $this->__data[$name];
        } else {
            throw new Exception('No Such Element', '0');
            return FALSE;
        }
    }

    function __set($name, $value) {
        
    }
    
     /* load and save to XML ...
     *    $this->__moduleSchema = ($schema !=NULL) ? $schema :
            $_ENV['cs']['schema_dir'].DIRECTORY_SEPARATOR.'module.xsd' ;
        $this->__moduleXmlFile = ($xmlFILE !=NULL) ? $schema :
            $_ENV['cs']['schema_dir'].DIRECTORY_SEPARATOR.'module.xsd' ;
	$this->__id = Utils.genID();

		
        if (!\CSModel\Utils::load_xml($schema, $xmlFile, $xml)) {
            return false;
        }

        $this->__data['id']
                = $xml->xpath("/set/@id");
        $this->__data['name']
                = $xml->xpath("/set/@name");
        $this->__data['parameters']
                = $xml->xpath("parameters");
        $this->__data['inputs']
                = $xml->xpath("inputs");

        return true;
    }
     */

}
?>
