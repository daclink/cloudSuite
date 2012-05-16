<?php

/**
 * Description of collection
 *
 * @author Drew A. Clinkenbeard
 */
class Collection {

    private $schema;
    private $xmlFile;
    private $name;
    private $id;
    private $clearance;
    private $collection;
    private $fileName;
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

    function __construct($desc, $ownerID, $name = NULL, $clearance = 10, $xmlFile = NULL, $schema = NULL) {

        if ($desc == NULL || $desc == "") {
            throw new Exception("Description can't be null", '1', null);
            return false;
        }

        if ($schema == NULL) {
            $schema = $_ENV['cs']['collection_dir'] . "collection.xsd";
        }

        $this->id = Utils::genID();

        $this->name = ($name == NULL) ? Utils::randomName() : $name;

        if ($xmlFile == NULL) {
            $xmlFile = Utils::fileName($this->id, $this->name);
        }

        $this->fileName = $xmlFile;

        $this->schema = $schema;
        $this->xmlFile = $xmlFile;

        $collection = new SimpleXMLElement("<collection></collection>");

        $collection->addAttribute('id', $this->id);
        $collection->addAttribute('name', $this->name);

        $collection->addChild("desc", $desc);
        $collection->addChild("ownerID", $ownerID);
        $collection->addChild("clearance", $clearance);
        $collection->addChild("created", date('Y-m-d'));

        $this->collection = $collection;

        return $collection;
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
        return $result;
        /*
          foreach ($result as $key => $value) {

          $id = intval((string) $result[$key]["id"]);
          $name = (string) $result[$key]["name"];
          $ret[$id] = $name;
          }

          return $ret; */
    }

    public static function getDesc($schema, $xmlFile) {
        if (!Utils::load_xml($schema, $xmlFile, $xml)) {
            return false;
        }

        return $xml->xpath("/collection/desc");
    }

    public static function getModuleByID($schema, $xmlFile, $id) {

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
        $module->addAttribute('id', $id);
        $module->addAttribute('filename', $modName . "." . $id . ".xml");



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

    function writeCollection($filename = NULL) {
        //convert to XML and store to the system.


        Utils::showStuff($this->fileName, 'This file name');

        if ($filename == NULL) {

            $filename = $_ENV['cs']['collection_dir'] . $this->fileName;
        }

        if (file_exists($filename)) {
            //TODO: add lock code.
        }

        $dom = new DOMDocument(1.0);
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($this->collection->asXML());

        if (!$dom->save($filename)) {
            Throw new Exception("Could not save file $filename", '2', NULL);
            return false;
        }
        //return $this->fileName;
        return true;
    }

    public static function delCollection($fileName, $clearance = 0) {

        if (!($clearance >= $_ENV['cs']['DEL_LEVEL'])) {
            throw new Exception("Not authorized to delete $fileName", '401', NULL);
        }

        $col = $_ENV['cs']['collection_dir'] . $fileName;

        if(!file_exists($col)) {
            throw new Exception("File $col not found", "404", NULL );
        }
        
        try {
            unlink($col);
        } catch (Exception $e) {
            throw new Exception("Could not Delete file $fileName", "500", $e);
        }

        return true;
    }

    /**
     *
     * @return String 
     */
    function getFileName(){
        return (String) $this->fileName;
    }
    
}

?>
