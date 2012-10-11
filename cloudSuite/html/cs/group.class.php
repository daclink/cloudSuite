<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of group.class.php
 *
 * @author Drew A. Clinkenbeard
 */
class Group {

    private $__groupXMLFile;
    private $__groupSchema;
    private $myXML;
 
    //private SimpleXMLElement $myXML;

    function __construct($schema = NULL, $xmlFile = NULL) {

        $this->__groupSchema = ($schema != null) ? $schema : $_ENV['cs']['schema_dir'] . "group.xsd";

        $this->__groupXMLFile = ($xmlFile != null) ? $xmlFile : $_ENV['cs']['groupFile'];

        if (Utils::load_xml($this->__groupSchema, $this->__groupXMLFile, $this->myXML)) {

            return true;
        } else {
            return false;
        }
    }

    function __destruct() {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    function getUserData($id, $value) {
        switch ($value) {
            case "lab":
            case "collection":
            case "lab":
                $xpath = "/groups/group/user[@id=$id]/../$value";
                Utils::showStuff($xpath, "XPATH ");
                return $this->myXML->xpath($xpath);
                break;
            case "groups":
                $returner = array();
                $ret_val = $this->myXML->xpath("/groups/group/user[@id=$id]/../@id");
                 foreach ($ret_val as $key => $value) {
                    echo "key = $key and value = $value";
                    //print_r($value["id"][0]);
                    $bar = $value["id"][0];
                    $foo = $this->myXML->xpath("/groups/group[@id=$bar]/@name");
                    //$returner[(int)$value] = $foo[0];
                    echo"bar";
                    $returner[$bar] = $foo[0][0];
                    print_r($bar);
                    echo "foo";
                    print_r($foo[0][0]);
                    
                }
                return $returner;
                ////|/groups/group/user[@id=$id]/../@name");
                break;
            default :
                return false;
        }
               
    }

    function addMemberToGroup($id, $type, $group) {
       
        
        
        switch ($type) {
            case "lab":
            case "collection":
            case "lab":
                $xpath = "/groups/group/user[@id=$id]/../$value";
                Utils::showStuff($xpath, "XPATH ");
                return $this->myXML->xpath($xpath);
                break;
            case "groups":
                return $this->myXML->xpath("//user[@id=$id]/..@id");
                break;
            default :
                return false;
        }
    }

}

?>
