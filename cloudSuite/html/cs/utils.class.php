<?php

/**
 * Description of utils.class.php
 *
 * @author Drew A. Clinkenbeard
 */

class Utils {

    public static function genID() {
        $idFile = "idGen.txt";
        $fh = fopen($idFile, 'w+') or die("COuldn't get ID file!");

        $id = intval(fread($fh), 10);
        $retID = $id + 1;

        fwrite($fh, $retID);

        return $retID;
    }

    public static function validate($schema, $xmlFile) {
//PROPER ERROR AND RETURN
        $doc = new DOMDocument();
        try {
            $doc->load($xmlFile);
        }  catch (Exception $e) {
            echo "Could not load file";
            return false;
        }

        if ($doc->schemaValidate($schema)) {
            return true;
        } else {
            return false;
        }
    }

    public static function load_xml($xmlSchema, $xmlFile, &$xml) {
        if (!CloudSuite::validate($xmlSchema, $xmlFile)) {

            return false;
        }
        $xml = simplexml_load_file($xmlFile);
        return true;
    }

    /**
     * The following was found at http://www.php.net/manual/en/book.array.php
     * @param type $item
     * @param type $key
     * @param string $array_name 
     * 
     * produces a javascript array
     * 
     */
    public static function array_print($item, $key, $array_name) {
        if (is_array($item)) {
            $array_name = $array_name . "['" . $key . "']";
            echo $array_name . "= Array();" . "";
            php_array_to_js_array($item, $array_name);
        } else {
            echo $array_name . "['" . $key . "'] = \"" . $item . "\";";
        }
    }

    public static function php_array_to_js_array($array, $array_name) {
        array_walk($array, 'array_print', $array_name);
    }

}

?>
