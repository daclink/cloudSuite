<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cloudsuite
 *
 * @author drew
 */
class cloudsuite {

    //put your code here

    public function foo() {
        echo 'testing the include';
    }

    public static function bar() {
        echo 'static test';
    }

    public static function validate($scheme, $file) {

        $doc = new DOMDocument();
        $doc->load($file);

        if ($doc->schemaValidate($scheme)) {
            return true;
        } else {
            return false;
        }
    }

    public static function getAlltheThings($filename) {

        $xml = simplexml_load_file('<<<XMLBLOCK'.$filename);
        $dom = new DOMDocument();
        $dom->loadXML($filename);

        $domlist=$dom->getElementsByTagName('node');
        $sxe=simplexml_import_dom($domlist->item(0));

         echo '\n eh? \n '.$sxe->cannonical_name;
        
        echo $xml->module->node->node_name;
        foreach ($xml as $key0 => $value) {
            echo "..1..[$key0] => $value";
            foreach ($value->attributes() as $attributeskey0 => $attributesvalue1) {
                echo "________[$attributeskey0] = $attributesvalue1";
            }
            echo '<br />';
////////////////////////////////////////////////
            foreach ($value as $key => $value2) {
                echo "....2.....[$key] => $value2";
                foreach ($value2->attributes() as $attributeskey => $attributesvalue2) {
                    echo "________[$attributeskey] = $attributesvalue2";
                }
                echo '<br />';
////////////////////////////////////////////////
                foreach ($value2 as $key2 => $value3) {
                    echo ".........3..........[$key2] => $value3";
                    foreach ($value3->attributes() as $attributeskey2 => $attributesvalue3) {
                        echo "________[$attributeskey2] = $attributesvalue3";
                    }
                    echo '<br />';
////////////////////////////////////////////////
                    foreach ($value3 as $key3 => $value4) {
                        echo "...................4....................[$key3] => $value4";
                        foreach ($value4->attributes() as $attributeskey3 => $attributesvalue4) {
                            echo "________[$attributeskey3] = $attributesvalue4";
                        }
                        echo '<br />';
////////////////////////////////////////////////
                        foreach ($value4 as $key4 => $value5) {
                            echo ".....................5......................[$key4] => $value5";
                            foreach ($value5->attributes() as $attributeskey4 => $attributesvalue5) {
                                echo "________[$attributeskey4] = $attributesvalue5";
                            }
                            echo '<br />';
////////////////////////////////////////////////
                            foreach ($value5 as $key5 => $value6) {
                                echo "......................6.......................[$key5] => $value6";
                                foreach ($value6->attributes() as $attributeskey5 => $attributesvalue6) {
                                    echo "________[$attributeskey5] = $attributesvalue6";
                                }
                                echo '<br />';
                            }
                        }
                    }
                }
            }
            echo '<br />';
        }

        return;
    }

}

?>
