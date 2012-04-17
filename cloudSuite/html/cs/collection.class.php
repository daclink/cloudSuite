<?php

/**
 * Description of collection
 *
 * @author Drew A. Clinkenbeard
 */

class Collection {

    private $schema;
    private $xmlFile;
    private $data = array('id' => '',
        'name' => '',
        'ownerID' => '',
        'clearance' => '',);
    

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

    function __construct($schema, $xmlFile) {
        $this->schema = $schema;
        $this->xmlFile = $xmlFile;
    }

    function __destruct() {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    public static function listModules($schema, $xmlFile) {

        $ret = array();

        if (!Utils::load_xml($schema, $xmlFile, $xml)) {
            return false;
        }
        $result = $xml->xpath("//module");

        foreach ($result as $key => $value) {

            $id = intval((string) $result[$key]["id"]);
            $name = (string) $result[$key]["name"];
            $ret[$id] = $name;
        }

        return $ret;
    }

    public static function getDesc($schema, $xmlFile) {
        if (!Utils::load_xml($schema, $xmlFile, $xml)) {
            return false;
        }
        
        return $xml->xpath("/collection/desc");
    }

    public static function getModuleByID($schema, $xmlFile, $id){
        
        if (!Utils::load_xml($schema, $xmlFile, $xml)) {
            return false;
        }
        
        return $xml->xpath("//module[@id=$id]");
        
    }
    
    
    public function listTheseModules() {

        $ret = array();

        if (!Utils::load_xml($schema, $xmlFile, $xml)) {
            return false;
        }
        $result = $xml->xpath("//module");

        foreach ($result as $key => $value) {

            $id = intval((string) $result[$key]["id"]);
            $name = (string) $result[$key]["name"];
            $ret[$id] = $name;
        }

        return $ret;
    }
    
    public function addModule($moduleObject) {

        if (!Utils::load_xml($xmlSchema, $xmlFile, $xml)) {
            throw new Exceptions("Couldn't access data");
        }

        $module = $xml->collection[0]->addChild($module);
        $modName = $moduleObject->getName;
        $id = Utill::genID();
       
        $module->addAttribute('name', $modName);
        $module->addAttribute('id', $id );
        $module->addAttribute('filename', $modName.".".$id.".xml" );



        $sysReqList = $moduleObject->getSystemRequiremts;


        reset($sysReqList);
        while (list($key, $val) = each($sysReqList)) {
            $sysReq = $module->addChild('systemRequirement');
            $sysReq->addChild('product', $moduleObject->getProduct);
            //  $sysReq->addChild('version', $moduleObject->get)
        }
        $fileInfo = $module->addChild('fileInfo');

        $fileInfo->addChild('kind', $moduleObject->getKind);
        $fileInfo->addChild('path', $moduleObject->getPath);

        $param = $fileInfo->addChild('parameter');
        $param->addChild('flag');
        $param->addChild('type');

        $output = $fileInfo->addChild('output');
    }

}
?>
