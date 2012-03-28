<?php
/**
*@author Drew A. Clinkenbeard
*CloudSuite module class.
*/
class Module {
    /* %******************************************************************************************% */

// CORE DEPENDENCIES
// Look for include file in the same directory (e.g. `./config.inc.php`).
    
    private $__moduleSchema;
    private $__moduleXmlFile;
    private $__data = array('id' => '',
                            'name' => '',
                            'systemRequirments' => array('product' => 'version'),
                            'fileInfo' => array('kind' => 'path'),
                            'parameter' => array(),
                            /*'parameter' => array('flag' => 
                                                array('value' =>'',
                                                      'description' =>'',
                                                      'required' =>'',
                                                      'dataType' =>'',
                                                      'default' => '',
                                                      'exclusive' => array('flag'),
                                                      'output' =>'')),*/
                            'input' => '',
                            'output' => '',
                            'clearance' => '',
                            'owner' => '',
                            'group' => '',
                            'everyone' => '');
                            
    function __construct($schema, $xmlFile) {
        if ($schema != null) {
            $this->__moduleSchema = $schema;
        } else {
            $this->__moduleSchema = $_ENV['cs']['schema_dir'] . "module.xsd";
        }
        
        if ($xmlFile != null) {
            $this->__moduleXmlFile = $xmlFile;
            $this->loadModule($this->__moduleSchema,  $this->__moduleXmlFile);
            return;
        }
        
        $this->__set('id', Utils::genID());
        
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
        
        if (array_key_exists($key, $this->__data)){
            $this->__data[$key] = $value; 
        } else {
            throw new Exception('no such element','0',NULL);
            return FALSE;
        }
    }
    
    function loadModule($schema, $xmlFile){
        if ($schema != null) {
            $this->__moduleSchema = $schema;
        }
       
        if ($xmlFile != null) {
            $this->__moduleXmlFile = $xmlFile;
        } else {
            throw new Exception('no File to load','2',NULL);
            return False;
        }
    }

    function removeParam($flag){

            if(!array_key_exists($this->__data['parameter'][$flag])){
                    throw new Exception('value not found');
                    return false;
            } else {

                unset($this->__data[$flag]);
                return true;
            }

    }

    function addParam($parameterArray){
    if(!is_array($parameterArray)) {
                    throw new Exception('Array excpected');
                    return false;
     }

            if (!array_key_exists('flag', $parameterArray)){
                    throw new Exception('Flag required');
                    return false; 
            }

            $this->__data['parameter'][$parameterArray['flag']] = 
                              array('description'   => $parameterArray['description'],
                                            'value'         => $parameterArray['value'],
                                            'required'      => $parameterArray['required'],
                                            'dataType'      => $parameterArray['dataType'],
                                            'default'       => $parameterArray['default'],
                                            'exclusive'     => $parameterArray['exclusive'],
                                            'input'     	=> $parameterArray['input'],
                                            'output'        => $parameterArray['output']); 
       /*    
       if (! $this->__data['parameter'][$parameterArray['flag']] = $parameterArray['flag']){
           throw new Exception('value requried');
           return false;
       }

       if (! $this->__data['parameter'][$parameterArray['flag']]['description'] = $parameterArray['description']){
            throw new Exception('Description requred');
            return false;
       }

       if (! $this->__data['parameter'][$parameterArray['flag']]['required'] = $parameterArray['required']){
           throw new Exception('required required (INCEPTION!)');
           return false;
       }

       if (! $this->__data['parameter'][$parameterArray['flag']]['dataType'] = $parameterArray['dataType']){
           throw new Exception('dataType Required');
           return false;
       }

       if (! $this->__data['parameter'][$parameterArray['flag']]['default'] = $parameterArray['default']){
           throw new Exception('default required');
           return false;
       }

       if ( is_array($parameterArray['exclusive'])){ 

           $foo = (Array)$parameterArray['exclusive'];

           foreach($foo as $key => $value){
               echo ("key($key) == value($value)");
            if(! $this->__data['parameter'][$parameterArray['flag']] = array($key=>$value )){
                throw new Exception('Exclusive required');
                return false;
             }    
           }

       } else {
           throw new Exception ('Exclusive must be an array');
           return false;
       }

       if (! $this->__data['parameter']['output'] = $parameterArray['output']){
           throw new Exception('output required');
           return FALSE;
       }

       print_r($this->__data);

        */
   } 

   function listParamters(){
       $params = $this->__data['parameter'];
       //print_r($params);
       return $params;
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
