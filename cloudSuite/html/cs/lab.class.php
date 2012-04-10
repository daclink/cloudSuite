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
    private $id;
    /**The data element contains all the data needed for a lab.
     * Owner, permisions, and an array of module objects stored with
     * the sequence number as the array key.
     */
    private $data = array('owner' => '',
                          'permissions' => array('owner'=>'7',
                                                 'group'=>'5',
                                                 'everyone'=>'4'),
                                                 'filename'=>'',
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

/*    public function addModule($moduleObject) {
            
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
	
        
        }*/
	
    //function __construct($user,$labSchema, $labXML) {
    function __construct($user) {
    $this->user = $user;
    $this->id = Utils::genID();
    $this->data['owner'] = $user;
    $this->data['permisions']['owner'] = 7;
    $this->data['permisions']['group'] = 4;
    $this->data['permisions']['everyone'] = 4;
    $this->data['labName'] = $this->user . "_" . date('YmdHis'). ".xml";
 
}

function writeLab(){
        //convert to XML and store to the system.
    $filename = "labs/".$this->data['labName'];
            $domDoc = new DOMDocument;
            $domDoc->formatOutput = true;
            
            $lab = $domDoc->createElement('lab');
              $labID = $domDoc->createAttribute('id');
              $labID->appendChild($domDoc->createTextNode($this->id));
              $lab->appendChild($labID);
    
                $owner = $domDoc->createElement('owner');
                $owner->appendChild($domDoc->createTextNode($this->data['owner']));
              $lab->appendChild($owner);
    
              $permissions = $domDoc->createElement('permissions');
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
       
              foreach ($this->data['modules'] as $key => $value) {
                  
                  $module = $domDoc->createElement('module');
                    $seqNum = $domDoc->createAttribute('seqNumber');
                        $seqNum->appendChild($domDoc->createTextNode($key));
                    $id = $domDoc->createAttribute('id');
                        $id->appendChild($domDoc->createTextNode($value['id']));
                        
                    $settings = $domDoc->createElement('settings');
                    $method = $domDoc->createElement('method');
                    $attrString = $domDoc->createElement('AttributeString');
                    
                    $settings->appendChild($domDoc->createTextNode($value['settings']));
                    $method->appendChild($domDoc->createTextNode($value['method']));
                    $attrString->appendChild($domDoc->createTextNode($value['attributeString']));
                    
                    $module->appendChild($seqNum);
                    $module->appendChild($id);
                    $module->appendChild($settings);
                    $module->appendChild($method);
                    $module->appendChild($attrString);
                    
                    $lab->appendChild($module);
              }
              
            $domDoc->appendChild($lab ); 
            
            $domDoc->save($filename);
              
    }

    static function readLab(String $filename, Module $module){
       $domDoc = new DOMDocument();
       $domDoc->load($_ENV['labs_dir'].$filename);
       
       //$lab = $domDoc->i
       
       return $domDoc;
       
    }
    
    function addModule($xmlFile, $xmlSchema, $moduleArray){
      
      if (array_key_exists($moduleArray['seqNumber'], $this->data['modules'])) {
          $temp = array(""=>"");
          foreach($this->data['modules'] as $key =>$vlaue) {
              if ($key >= $moduleArray['seqNumber'] ) {
                  $temp[$key+1] = $value;
              }
          }
          $this->data['modules'] + $temp;
       }
      
      $this->data['modules'][$moduleArray['seqNumber']] = array(
                            'id' => $moduleArray['id'],
                            'settings' => $moduleArray['settings'],
                            'method' => $moduleArray['method'],
                            'attributeString' => $moduleArray['attrString']
                            );

      }
      
    function listModules() {
        return $this->data['modules'];
        
    }

    public static function loadLab($labID){

    }

    function runLab(){
        $request = xmlrpc_encode_request($method, $params);
        $context = stream_context_create(
                array('http' => 
                    array ('method'    => "POST",
                           'header'    => "Content-Type: text/xml",
                           'content'   => $request
                          )
                    )
                );
        
    }
        
     
}

?>
