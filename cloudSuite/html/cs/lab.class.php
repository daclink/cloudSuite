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
class lab {

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

        if (!CloudSuite::load_xml($xmlSchema, $xmlFile, $labXML)) {
            throw new Exceptions("Couldn't access data");
        }

        $module = $labXML->set[0]->addChild($module);

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

    /*
      function __construct($user) {
      $this->__user = $user;
      }

      function writeLab(){

      }

      function readLab(){

      }

      function getSets(){

      }

      function getSets() {
      return $this->__sets;
      }

      function getModules() {
      return $this->__modules;
      }
     */
}

?>
