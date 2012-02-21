<?php
/**
*@author Drew A. Clinkenbeard
*CloudSuite module class.
*/
class module {
    /* %******************************************************************************************% */

// CORE DEPENDENCIES
// Look for include file in the same directory (e.g. `./config.inc.php`).

    private $schema;
    private $xmlFile;
    private $data = array('id' => '',
        'name' => '',
        'parameters' => array(''),
        'outputs' => array(''),
        'inputs' => array(''));

    function __construct($schema, $xmlFile) {

        $this->schema = $schema;
        $this->xmlFile = $xmlFile;

        if (!CloudSuite::load_xml($schema, $xmlFile, $xml)) {
            return false;
        }

        $this->data['id']
                = $xml->xpath("/set/@id");
        $this->data['name']
                = $xml->xpath("/set/@name");
        $this->data['parameters']
                = $xml->xpath("parameters");
        $this->data['inputs']
                = $xml->xpath("inputs");

        return true;
    }

    function __destruct() {
        foreach ($this as $key => $value) {
            unset($this->$key);
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

    function __set($name, $value) {
        
    }

}
class module {
    /* %******************************************************************************************% */

// CORE DEPENDENCIES
// Look for include file in the same directory (e.g. `./config.inc.php`).

    private $schema;
    private $xmlFile;
    private $data = array('id' => '',
        'name' => '',
        'parameters' => array(''),
        'outputs' => array(''),
        'inputs' => array(''));

    function __construct($schema, $xmlFile) {

        $this->schema = $schema;
        $this->xmlFile = $xmlFile;

        if (!CloudSuite::load_xml($schema, $xmlFile, $xml)) {
            return false;
        }

        $this->data['id']
                = $xml->xpath("/set/@id");
        $this->data['name']
                = $xml->xpath("/set/@name");
        $this->data['parameters']
                = $xml->xpath("parameters");
        $this->data['inputs']
                = $xml->xpath("inputs");

        return true;
    }

    function __destruct() {
        foreach ($this as $key => $value) {
            unset($this->$key);
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

    function __set($name, $value) {
        
    }

}
?>
