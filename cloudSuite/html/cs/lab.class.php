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

    private $__labSchema;
    private $__xmlFile;
    private $__labXML;
	private $__user;
    
    private $data = array('sets' => '',
        'modules' => '',
        'user' => '');

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

    public function addModule($moduleObject) {

        
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
	}
	
	function __construct($user,$labSchema, $labXML) {
    	$this->__user = $user;
		$this->__labSchema = ($labSchema == null) ? $ENV_['cs']['labSchema'] : $labSchema;

 $_ENV['cs']['schema_dir'] = 'schema'.DIRECTORY_SEPARATOR; 
    }

   	function writeLab(){
	
	}

	function readLab(){
	
	}

	public static function loadLab($labID){
   
   }
     
}

?>
