<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of lab
 *
 * @author drew
 */
class Lab {

    private $labSchema;
    private $xmlFile;
    private $labXML;
    private $user;
    /**The data element contains all the data needed for a lab.
     * Owner, permisions, and an array of module objects stored with
     * the sequence number as the array key.
     */
    private $data = array('owner' => '',
                          'permissions' => array('owner'=>'7',
                                                 'group'=>'5',
                                                 'everyone'=>'4'),
                           'module' => array(0=>'moduleObject') );

    function __set($key, $value) {
        if (array_key_exists($key, $this->data)) {
            $this->data[$key] = $value;
            return true;
        } else {
            throw new Exception('No Such Element', '0');
            return FALSE;
        }
    }

    function __get($key) {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        } else {
            throw new Exception('No Such Element', '0');
            return FALSE;
        }
    }

    public function addModule($moduleObject) {

        $seq = $moduleObject->__get('sequenceNumber');
        
        if ($seq > 0) {
            if(array_key_exists($seq, $this->data["module"])){
                throw new Exception('Sequence number already exists');
                return false;
                }
            $this->data["module"][$seq] = $moduleObject;
            return true;
        }
        /*
        $module = $_labXML->set[0]->addChild($module);

        $module->addAttribute('name', $moduleObject->getName);
        $module->addAttribute('id', Utill::genID());

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
	
        */
        }
	
	function __construct($user,$labSchema, $labXML) {
    	$this->user = $user;
	
        $this->data["owner"] = $user->__get("id");
        
        $this->labSchema = ($labSchema == null) ? $ENV_['cs']['labSchema'] : $labSchema;
        //$_ENV['cs']['schema_dir'] = 'schema'.DIRECTORY_SEPARATOR; 
    }

   	function writeLab(){
            //convert to XML and store to the system.
	}

	function readLab(){
            //convert from XML and store to the system.
	}

	public static function loadLab($labID){
   
        }
        
        function runLab(){
            
        }
     
}

?>
