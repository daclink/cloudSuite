<?php

/**
 * @author Drew A. Clinkenbeard
 * CloudSuite module class.
 */
class Module {
    /* %******************************************************************************************% */

// CORE DEPENDENCIES
// Look for include file in the same directory (e.g. `./config.inc.php`).

    private $myXML;
    private $fileName;
    private $__moduleSchema;
    private $__moduleXmlFile;
    private $__data = array('id' => '',
        'name' => '',
        'systemRequirments' => array('product' => 'version'),
        'fileInfo' => array('kind' => 'path'),
        'parameter' => array(),
        /* 'parameter' => array('flag' => 
          array('value' =>'',
          'description' =>'',
          'required' =>'',
          'dataType' =>'',
          'default' => '',
          'exclusive' => array('flag'),
          'output' =>'')),
         */
        'input' => '',
        'output' => '',
        'clearance' => '',
        'owner' => '',
        'group' => '',
        'everyone' => '');

    /**
     * Creates and returns a module object
     * 
     * @param String $schema
     * @param String $xmlFile
     * @param String $name 
     * @return module Object
     */
    function __construct($creator, $type, $schema = NULL, $xmlFile = NULL, $name = NULL) {
        if ($schema != NULL) {
            $this->__moduleSchema = $schema;
        } else {
            $this->__moduleSchema = $_ENV['cs']['schema_dir'] . "module.xsd";
        }

        if ($xmlFile != NULL) {

            $this->__moduleXmlFile = $xmlFile;
            Utils::load_xml($schema, $xmlFile, $xml);
            $this->myXML = $xml;
            $this->fileName = Utils::fileName($xml['id'], $xml['name']);
            return true;
        }

        $myXML = new SimpleXMLElement('<module></module>');

        $id = Utils::genID();
        $name = ($name == NULL) ? Utils::randomName() : $name;
        $this->fileName = Utils::fileName($xml['id'], $xml['name']);

        $myXML->addAttribute('id', $id);
        $myXML->addAttribute('name', $name);

        $moduleType = $myXML->addChild('moduleType', $type);

        $description = $myXML->addChild('description');

        $systemReq = $myXML->addChild('systemRequirement');
        $systemReq->addChild('product');
        $systemReq->addChild('version');

        $fieldset = $myXML->addChild('fieldset');
        $fieldset->addChild('legend');

        $element = $fieldset->addChild('element');
        $element->addChild('type');
        $element->addChild('name');
        $element->addChild('value');
        $element->addChild('description');
        $element->addChild('input');
        $element->addChild('output');
        $element->addChild('required');
        $element->addChild('defualt');

        $permissions = $myXML->addChild('permissions');
        $permissions->addChild('owner');
        $permissions->addChild('group');
        $permissions->addChild('everyone');
        $permissions->addAttribute('clearance', '9');

        $methodName = $myXML->addChild('methodName');
        $createdBy = $myXML->addChild('createdBy', $creator);
        $dateCreated = $myXML->addChild('dateCreated', date('Y-m-d'));

        $modType = $myXML->addChild('moduleType');

        $this->myXML = $myXML;

        return true;
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

    function __set($key, $value) {

        if (array_key_exists($key, $this->__data)) {
            $this->__data[$key] = $value;
        } else {
            throw new Exception('no such element', '0', NULL);
            return FALSE;
        }
    }

    static function getModuleForm($xmlFile, $xmlSchema = NULL, $labFileName = NULL) {

        if ($xmlSchema == NULL) {
            $xmlSchema = $_ENV['cs']['schema_dir'] . "module.xsd";
        }

        if ($labFileName != NULL) {
            echo "<input type='hidden' value='$labFileName' name='labFileName' />";
        }
        if (!Utils::load_xml($xmlSchema, $xmlFile, $xml)) {
            throw new Exception("Could not load file $xmlFile", '1', NULL);
            return false;
        }
        echo "<h4 class='modTitle'>" . $xml['name'] . "</h4>";
        echo "<form id='addModForm' onSubmit='addFormTolab()' action=''>";
        //echo "<form id='addModForm' onSubmit='' action='cloudCommand/modForm'>"; 
        echo "<input id='edit-mod-name' type='hidden' value='$xmlFile' />";

        $module['moduleType'] = $xml->xpath("//moduleType");
        $module['description'] = $xml->xpath("/module/description");
        $module['systemRequirement'] = $xml->xpath("//systemRequirement");
        $module['fieldset'] = $xml->xpath("//fieldset");
        $module['permissions'] = $xml->xpath("//permissions");
        $module['methodName'] = $xml->xpath("//methodName");
        $module['createdBy'] = $xml->xpath("//createdBy");
        $module['dateCreated'] = $xml->xpath("//dateCreated");
        $module['id'] = $xml['id'];

        $fs = $xml->xpath("//fieldset");


        foreach ($fs as $key) {
            echo "<fieldset>";
            echo "<legend>" . $key->legend . "</legend>";
            foreach ($key->element as $element) {

                //print_r($element);

                $id = $element['id'];
                echo "<input type='hidden' value='$id'>";
                echo "<input id='$id' type='" . $element->type . "' name=" . $element->name . " value='$element->value'> $element->description </input>";
                if ($element->input) {
                    echo "<div class=\"moduleInput\">$element->input</div>";
                }
                //echo "</input>";
                echo "<br />";
            }
            echo "</fieldset>";
        }
        $labName = explode('.', $labFileName);
        echo "<div id='cancelModForm-button' class='modButton chiClick csshadow'> Cancel </div>";
        if (array_key_exists(1, $labName)) {
            //    echo "<button id='addModForm-button' type='submit' class='modButton chiClick csshadow'> Add to $labName[1] </button>";
            echo "<div id='addModForm-button' class='modButton chiClick csshadow'> Add to $labName[1] </div>";
        } else {
            echo "<div id='' class='modButton csshadow'> No lab loaded. </div>";
        }
        echo "</form>";
    }

    static function loadDataModule($bucket, $filename, $labFileName, $xmlSchema=null) {

        $data_bucket = 'cloudsuite.data.warehouse';

        if ($xmlSchema == NULL) {
            $xmlSchema = $_ENV['cs']['schema_dir'] . "module.xsd";
        }

        if ($labFileName != NULL) {
            echo "<input type='hidden' value='$labFileName' name='labFileName' />";
        }

        $s3 = Utils::getS3Instance();

        $response = $s3->get_object($bucket, $filename);

        if (!$response->isOK()) {
            return false;
        }

        $xmlFile = $response->body;

        if (!Utils::load_xml($xmlSchema, $xmlFile, $xml, true)) {
            throw new Exception("Could not load file $xmlFile", '1', NULL);
            return false;
        }

        $module['moduleType'] = $xml->xpath("//moduleType");
        $module['description'] = $xml->xpath("/module/description");
        $module['systemRequirement'] = $xml->xpath("//systemRequirement");
        //$module['fieldset'] = $xml->xpath("//fieldset");
        $module['permissions'] = $xml->xpath("//permissions");
        $module['methodName'] = $xml->xpath("//methodName");
        $module['createdBy'] = $xml->xpath("//createdBy");
        $module['dateCreated'] = $xml->xpath("//dateCreated");
        $module['id'] = $xml['id'];
        $module['name'] = $xml['name'];
        $module['data'] = $xml->data;

        echo "<h4 class='modTitle'>" . $module['description'][0] . "</h4>";
        //echo "<form id='addModForm' onSubmit='addFormTolab()' action=''>";
        echo "<div id='dataDisplay'>";
        //echo "<form id='addModForm' onSubmit='' action='cloudCommand/modForm'>"; 
        // echo "<input id='edit-mod-name' type='hidden' value='$xmlFile' />";

        try {
            $s3->set_object_acl($data_bucket, $module['data'][0], array(
                array('id' => AmazonS3::USERS_ALL, 'permission' => AmazonS3::GRANT_FULL_CONTROL)
                    )
            );
            $data_url = $s3->get_object_url('cloudsuite.data.warehouse', $module['data'][0]);
            $data_name = $module['id'] . "." . $module['name'] . ".xml";
        } catch (Exception $e) {
            $data_url = $data_name = false;
        }
        
        echo "<ul>";
        //echo "<li> </li>";
        echo "<li>Owner      : " . $module['createdBy'][0] . "</li>";
        echo "<li>Created on : " . $module['dateCreated'][0] . "</li>";
        echo "<li>data_name : " . $data_name . "</li>";
        echo "<li>Module ID : " . $module['id'] . "</li>";
        echo "<li>Module Name : " . $module['name'] . "</li>";
        if ($data_url) {
            echo "<li><a href=\"" . $data_url . "\" target='_blank'>Download Data File : ".$module['data'][0]."</a></li>";
        } else {
            echo "<li>Warning : could not find associated data.</li>";
        }
        echo "</ul>";
        echo "<input id=\"hiddenDataMod\" type=\"hidden\" value=\"" . $data_name . "\"></input> ";

        $labName = explode('.', $labFileName);
        //echo "<div id='closeData' class='modButton chiClick csshadow'> Close </div>";
        //echo "<div id='deleteData' class='modButton chiClick csshadow'> Delete </div>";
        //echo "</form>";
        echo "</div>";
    }

    static function delDataMod($filename, $bucket) {

        $bucket = strtolower($bucket);
        
        $s3 = Utils::getS3Instance();

        $data_bucket = 'cloudsuite.data.warehouse';

        $xmlSchema = $_ENV['cs']['schema_dir'] . "module.xsd";

        $s3 = Utils::getS3Instance();

        $response = $s3->get_object($bucket, $filename);

        if (!$response->isOK()) {
            throw new Exception("Could not load file $filename", '1', NULL);
            return false;
        }

        $xmlFile = $response->body;

        if (!Utils::load_xml($xmlSchema, $xmlFile, $xml, true)) {
            throw new Exception("Could not load file $xmlFile", '1', NULL);
            return false;
        }

        $data = $xml->data;
        
        echo "deleting $data[0]";
        
        return $s3->delete_object($data_bucket, $data[0])->isOK() && $s3->delete_object($bucket, $filename)->isOK();
    }

    static function loadModule($xmlFile, $xmlSchema=NULL) {

        if ($xmlSchema == NULL) {
            $xmlSchema = $_ENV['cs']['schema_dir'] . "module.xsd";
        }

        if (!Utils::load_xml($xmlSchema, $xmlFile, $xml)) {
            throw new Exception("Could not load file $xmlFile", '1', NULL);
            return false;
        }

        //__construct($creator, $type, $schema = NULL, $xmlFile = NULL, $name = NULL)
        return new Module($xml->createdBy, $xml->moduleType, $xmlSchema, $xmlFile, NULL);
    }

    function removeParam($flag) {

        if (!array_key_exists($this->__data['parameter'][$flag])) {
            throw new Exception('value not found');
            return false;
        } else {

            unset($this->__data[$flag]);
            return true;
        }
    }

    function addParam($parameterArray) {
        if (!is_array($parameterArray)) {
            throw new Exception('Array excpected');
            return false;
        }

        if (!array_key_exists('flag', $parameterArray)) {
            throw new Exception('Flag required');
            return false;
        }

        $this->__data['parameter'][$parameterArray['flag']] =
                array('description' => $parameterArray['description'],
                    'value' => $parameterArray['value'],
                    'required' => $parameterArray['required'],
                    'dataType' => $parameterArray['dataType'],
                    'default' => $parameterArray['default'],
                    'exclusive' => $parameterArray['exclusive'],
                    'input' => $parameterArray['input'],
                    'output' => $parameterArray['output']);
    }

    function listParamters() {
        $params = $this->__data['parameter'];
        //print_r($params);
        return $params;
    }

    function listParametersByID($id) {
        
    }

    /**
     *
     * @return SimpleXMLElement 
     */
    public function getSimpleXML() {

        return $this->myXML;
    }

}

?>
