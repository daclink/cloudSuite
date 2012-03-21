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
                           'modules' => array(0=>'moduleObject') );

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
            
        try{
            $this->data['modules'][$moduleObject->__get('id')] = $moduleObject;
            return true;
    }catch (Exception $e){
        echo "there was a problem $e->__toString()";
        return false;
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
	
      //  $uid = $user->__get('id');
        
        $this->__set('owner', $user);
        
        $this->labSchema = ($labSchema == null) ? $_ENV['cs']['schema_dir'] . 'lab.xsd' : $labSchema;
        //$_ENV['cs']['schema_dir'] = 'schema'.DIRECTORY_SEPARATOR; 
    }

   	function writeLab(){
            //convert to XML and store to the system.
            $domDoc = new DOMDocument;
            $lab = $domDoc->createElement('lab');
              $labID = $domDoc->createAttribute('id');
              $labID->appendChild($domDoc->createTextNode($this->data['id']));
              $lab->appendChild($labID);
              
                $owner = $domDoc->createElement('owner');
                $owner->appendChild($domDoc->createTextNode($this->data['owner']));
              $lab->appendChild($owner);
              
              $permissions = $domDoc->createElement('permissons');
                  $owner = $domDoc->createElement('owner');
                    $owner->appendChild($domDoc->createTextNode($this->data['permissions']['owner']));
                  $group = $domDoc->createElement('group');
                    $group->appendChild($domDoc->createTextNode($this->data['permissions']['group']));
                  $everyone = $domDoc->createElement('everyone');
                    $everyone->appendChild($domDoc->createTextNode($this->data['permissions']['everyone']));
                $permissions->appendChild($owner);
                $permissions->appendChild($group);
                $permissions->appendChild($everyone);
              $lab->appendChild($permissions);
             
            
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
