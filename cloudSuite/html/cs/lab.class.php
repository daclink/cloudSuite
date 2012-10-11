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
    private $user;
    private $id;
    private $labname;
    private $fileName;
    private $description;
    
    private $lastRunDate;
    private $lastRunUser;
    
    private $owner;
    private $permissions =array('owner'=>'',
                                'group'=>'',
                                'everyone'=>'');
    private $module = array('1' => 
                        array('id'            => '',
                              'moduleName'    => '',
                              //'seqNumber'     => '',
                              'method'        => '',
                              'xmlrpcString'  => '',
                              'filename'      => '',
                              'input' => 
                                    array( 'type'       => '',
                                           'filename'   => '',
                                           'location'   => ''
                                        ),
                              'output' => 
                                    array( 'type'       => '',
                                           'filename'   => '',
                                           'location'   => ''
                                        )
                             )
                           );

    private $lab;
    
    /**DEPRICATED The data element contains all the data needed for a lab.
     * DEPRICATED Owner, permisions, and an array of module objects stored with
     * DEPRICATED the sequence number as the array key.
     * 
     * The correct way to access data is by calling it directly. The
     * 'magic' getters and setters were too confusing.
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

    function __construct($owner, $id = NULL, $labName = NULL, $description = NULL, $xml=NULL) {
        $this->user = $owner;
        
        Utils::showStuff($labName, 'IN CONSTRUCT LABNAME');

        
        $this->id = ($id == NULL) ? Utils::genID() : $id;
        
        if ($labName != NULL){
            $this->labname = $labName;
        } else {
            $this->labname = Utils::randomName();            
        }
        
        if ($description != NULL){
            $this->description = $description;
        } else {
            $this->description = "$owner made an unknown lab.";            
        }
        
        Utils::showStuff($this->labname, 'this lab name...');
        
        $lname = Utils::fileName($this->id, $this->labname);
         
        $this->fileName = Utils::fileName($this->id, $this->labname);
        
        if ($xml != NULL ) {
            $this->lab = $xml;
            return true;
        }

        $lab = new SimpleXMLElement('<lab></lab>');
        $lab->addAttribute('id', $this->id);
        $lab->addAttribute('labName', $this->labname);


        $lab->addChild('owner', $owner);
        $lab->addChild('description', $description);

        $permissions = $lab->addChild('permissions');
        $permissions->addChild('owner', '7');
        $permissions->addChild('group', '4');
        $permissions->addChild('everyone', '4');

        $lab->addChild('lastRunDate', '0');
        $lab->addChild('lastRunUser', '0');
        
        /*
        $module = $lab->addChild('module');
        $module->addAttribute('id', '-1');
        $module->addAttribute($name, $value)
        */

        $this->lab = $lab;

        return $lab;

    }

    function setFileName($labName) {
        
        $labName = str_replace(" ","_",$labName);
        
        $this->lab['labName'] = $labName;
        $this->fileName = Utils::fileName($this->lab['id'], $labName);
        
        $foo = new SimpleXMLElement("<lab></lab>");
        $foo->addChild('bar');
        
    }
    
    function getFileName(){
        
        return $this->fileName;
    }
    /**
     *
     * @param string $filename
     * @return Success String
     * @return fail False
     * 
     * Always expects a FULL path name so append $_ENV['cs']['labs_dir']
     */
    function writeLab($filename = NULL){
            //convert to XML and store to the system.
        
       // if (! Utils::validate($this->labSchema, $this->lab->asXML())){
        //    Throw new Exception("invalid Lab structure.", '1', Null);
         //   return false;
       // }
        
        //Utils::showStuff($this->fileName, 'This file name');
        
        if($filename == NULL){
             
            $filename = $_ENV['cs']['labs_dir'] . $this->fileName;
        }
        
        
        if (file_exists($filename)){
            //TODO: add lock code.
        }
        
        $dom = new DOMDocument(1.0);
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($this->lab->asXML());       
        
        if(! $dom->save($filename)){
            Throw new Exception("Could not save file $filename", '2', NULL);
            return false;
        }
        //return $this->fileName;
        return true;
    }

    function getLab(){
        return $this->lab;
    }
    
    static function readLab(String $filename){
       $domDoc = new DOMDocument();
       $domDoc->load($_ENV['labs_dir'].$filename);
       
       //$lab = $domDoc->i
       
       return $domDoc;
       
    }
    /**
     *
     * @param type $xmlFile must append lab directory
     * @param string $xmlSchema
     * @return Lab 
     */
    public static function loadLab($xmlFile, $xmlSchema = NULL){
        
        if($xmlSchema == null){
            $xmlSchema= $_ENV['cs']['schema_dir'].'lab.xsd';
        }
        if($xmlFile == null){
            throw new Exception("XML File must not be null", "1", null);
            return false;
        }
        
        if (!Utils::load_xml($xmlSchema, $xmlFile, $xml)){
            throw new Exception("could not load file.", "2", null);
            return false;
        }
        
        $owner = (String) $xml->owner;
        $id = (String) $xml['id'];
        $labName = (String) $xml['labName'];
        $description = (String) $xml->description;

        return new Lab( $owner , $id, $labName, $description, $xml);
         
    }
    
    /**
     *
     * @param SimpleXMLElement $moduleXML 
     * @param String $xmlFile
     * @param String $xmlSchema
     * @param String $seqNumber
     * @return Boolean 
     */
    function addModule($moduleXML, $xmlFile = NULL, $xmlSchema = NULL, $seqNumber = NULL){
        
        if ( $xmlSchema == NULL && $this->labSchema != NULL) {
            $xmlSchema = $this->labSchema;     
        } else {
            $xmlSchema = $_ENV['cs']['schema_dir'].'lab.xsd';
        }
        //Utils::showStuff($xmlSchema, 'schema');
        
        $modules = $this->lab->module;
        
        $seqNumber  = ($seqNumber > sizeof($modules) +1) ? (sizeof($modules) + 1) : $seqNumber;
        $id = ($moduleXML->module['id'] == NULL) ? Utils::genID() : $moduleXML['id'];
      
        if ($seqNumber != NULL && $seqNumber < sizeOf($modules)) {
            foreach ($modules as $module){
                if($module->seqNumber == $moduleXML->seqNumber){
                    $module->seqNumber = $module->seqNumber +1;
                }elseif ($module->seqNumber > $moduleXML->seqNumber ) {
                    $module->seqNumber = $module->seqNumber +1;
                }
                
            }
          
      } else {
          $seqNumber = sizeof($modules) + 1;
      }
      
      $module = $this->lab->addChild('module');
      
   
      $module->addAttribute('id', $id);
      $module->addAttribute('moduleName', (String) $moduleXML['name']);
      
      $module->addChild('seqNumber', $seqNumber);
      $module->addChild('method', $moduleXML->methodName);
      //$module->addChild('xmlrpcString', $moduleXML->xmlrpcString);
      //$module->addChild('filename', $moduleXML->filename);
      
      //TEMPORARY HACK FIX
      $module->addChild('xmlrpcString', "one");
      $module->addChild('filename', Utils::fileName($moduleXML['id'], $moduleXML['name']));
      
      /*input and output MUST be pulled from the form. 
       * It doesn't make sense to pull it from the module as these values
       * ARE NOT KNOWN to the module. The input and output in the module
       * would more correctly be labled 'input TYPE' and 'output TYPE'
       * 
       * sorry about the confusion.
       * 
       * to add to the confusion the input and output are now known to the module SOMEWHAT.
       * Inputs are now ONLY modules new data is added by creating a new module.
       * Outputs are, also, modules. A method will be created to download data
       * from modules.
       * 
       */
      
      //$fieldset = $module->addChild('fieldset');
      
      /*
      $input = $module->addChild('input');
      $input->addChild('type', 'input type');
      $input->addChild('filename', 'filename');
      $input->addChild('location', 'location');
      
      
      $output = $module->addChild('output');
      $output->addChild('type', 'output->type');
      $output->addChild('filename', 'output->filename');
      $output->addChild('location', 'output->location');
      */
      /*$input = $module->addChild('input', $moduleXML->input);
      $input->addChild('type', $moduleXML->input->type);
      $input->addChild('filename', $moduleXML->input->filename);
      $input->addChild('location', $moduleXML->input->location);
      
      
      $output = $module->addChild('output',$moduleXML->output);
      $output->addChild('type', $moduleXML->output->type);
      $output->addChild('filename', $moduleXML->output->filename);
      $output->addChild('location', $moduleXML->output->location);
     */
      
    //  if (! Utils::validate($xmlSchema, $this->lab->asXML())) {
    ////      Throw new Exception("Bad module.", '3',NULL);
    //      return false;
    //  }
      
      return true;
      
    }
      
    function getModules() {
        return $this->lab->module;
        
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
    
    public static function runAllLabs($xmlSchema = NULL, $labDirectory = NULL) {
        if($xmlSchema == null){
            $xmkSchema= $_ENV['cs']['schema_dir'].'lab.xsd';
        }
        if($labDirectory == null){
            $labDirectory = $_ENV['cs']['labs_dir'];
        }
        
        $labs = Utils::returnFiles($labDirectory);
        
        print_r($labs);
        
    }
    
    
    public function getSimpleXML() {
        
        return $this->lab;
        
    }
    
    public static function delLab($fileName, $clearance = 0) {

        if (!($clearance >= $_ENV['cs']['DEL_LEVEL'])) {
            throw new Exception("Not authorized to delete $fileName", '401', NULL);
        }

        $lab = $_ENV['cs']['labs_dir'] . $fileName;

        if(!file_exists($lab)) {
            throw new Exception("File $lab not found", "404", NULL );
        }
        
        try {
            unlink($lab);
        } catch (Exception $e) {
            throw new Exception("Could not Delete file $fileName", "500", $e);
        }

        return true;
    }
    
    static function removeModuleById ($labID, $id) {
        
        $labs = Utils::returnFiles($_ENV['cs']['labs_dir']);
        
        $xmlSchema = $_ENV['cs']['schema_dir'] . "lab.xsd";
        
        Utils::showStuff($labID, "lab ID");
        Utils::showStuff($id, "id");
        Utils::showStuff($labs, "labs");
        
        foreach ($labs as $lab){
            $parts = explode(".", $lab);
            
            if($parts[0] == $labID) {
                $filename = $_ENV['cs']['labs_dir'] . $lab;
                Utils::load_xml($xmlSchema, $filename , $xml);
                break;
            }
        }
        
        //Utils::showStuff($xml->xpath("//module[@id='$id']"));
        
        //Utils::showStuff($xml->xpath("//module[@id=$id]"),'direct');
        
        
        // Utils::showStuff($xml,"after unset");
         
        $dom_sxe = dom_import_simplexml($xml);
        
        if (!$dom_sxe) {
            throw new Exception("Could not load file", "1", null);
            exit;
        }
        
        $dom = new DOMDocument('1.0');
        $dom_sxe = $dom->importNode($dom_sxe, true);
        $dom_sxe = $dom->appendChild($dom_sxe);
         
        $xpath = new DOMXPath($dom);
        
        foreach($xpath->query("//module[@id=$id]") as $node){
            $node->parentNode->removeChild($node);
        }
        
        
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        
        if (!$dom->save($filename)) {
            Throw new Exception("Could not save file $filename", '3', NULL);
            return false;
        }
        //return $this->fileName;
        return true;
         
    }
    
    public static function loadLabbyID($labID) {
        
        $labs = Utils::returnFiles($_ENV['cs']['labs_dir']);
        
        $xmlSchema = $_ENV['cs']['schema_dir'] . "lab.xsd";
        
        Utils::showStuff($labID, "lab ID");
        Utils::showStuff($labs, "labs");
        
        foreach ($labs as $lab){
            $parts = explode(".", $lab);
            
            if($parts[0] == $labID) {
                $filename = $_ENV['cs']['labs_dir'] . $lab;
                Utils::load_xml($xmlSchema, $filename , $xml);
                break;
            }
        }
        Utils::showStuff($xmlSchema, 'schema');
        Utils::showStuff($filename, 'filename');
        
        Utils::load_xml($xmlSchema, $filename, $xml);
        
        return new Lab($xml->owner, $labID, $xml['labName'], $xml->description, $xml);
        
    }
    
}

?>
