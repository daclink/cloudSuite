<?php

/**
 * Description of utils.class.php
 *
 * @author Drew A. Clinkenbeard
 */
class Utils {

    public static function genID() {
        $idFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.idGen';
        $fh = fopen($idFile, 'r') or die("Couldn't get ID file!");
        if (!flock($fh, LOCK_EX)) {
            throw new Exception('Could not get file lock. Try again', '6');
            return -1;
        }

        $id = file_get_contents($idFile);
        $retID = $id + rand(2, 5);
        #$retID = str_pad($retID, 12, "0", STR_PAD_LEFT);

        if (!file_put_contents($idFile, $retID)) {
            flock($fh, LOCK_UN);
            throw new Exception('Could not write file');
            return -1;
        }

        flock($fh, LOCK_UN);
        fclose($fh);
        return $retID;
    }

    public static function fileWrite($xml, $fileDir, $filename) {
        Utils::showStuff($fileDir, 'In utils file directory');
        Utils::showStuff($filename, 'filename');
        Utils::showStuff($xml, 'xml is');
        $fileToWrite = $fileDir . $filename;
        $fh = fopen($fileToWrite, 'r') or die("Couldn't get file!");
        if (!flock($fh, LOCK_EX)) {
            throw new Exception('Could not get file lock. Try again', '6');
            return -1;
        }

        if (!file_put_contents($fileToWrite, $xml)) {
            flock($fh, LOCK_UN);
            throw new Exception('Could not write file');
            return -1;
        }

        flock($fh, LOCK_UN);
        fclose($fh);
        // return $retID;
    }

    public static function validate($schema, $xmlFile = NULL) {
//PROPER ERROR AND RETURN
        //Utils::showStuff($xmlFile, 'UTILS XML FILE');
        Utils::showStuff($schema, 'UTILS SCHEMA');

        $doc = new DOMDocument();
        
        try {

            $doc->load($xmlFile);

            if ($doc->schemaValidate($schema)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception("Could not load $xmlFile", $e->getCode(), $e->getPrevious());
            return false;
        }
    }

    public static function load_xml($xmlSchema, $xmlFile, &$xml) {
        if (!Utils::validate($xmlSchema, $xmlFile)) {

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

    public static function showStuff($string, $label = NULL) {
        if ($_ENV['cs']['debug'] == TRUE) {
            echo "\n<h1> $label </h1><pre>";
            print_r($string);
            echo "</pre><h1> $label </h1><pre>\n";
        }
    }

    public static function returnFiles($folder) {
        $ret = array();

        if ($handle = opendir($folder)) {
            while (false !== ($entry = readdir($handle))) {

                if ($entry != "." && $entry != "..") {
                    array_push($ret, $entry);
                }
            }

            closedir($handle);
        }

        return $ret;
    }

    public static function randomName() {

        $name = array('Malcom',
            'Kaylee',
            'Jayne',
            'Book',
            'Inara',
            'Simon',
            'River',
            'Wash',
            'Luke',
            'Leia',
            'Anaken',
            'Han',
            'Chewie',
            'BobbaFett'
        );

        return strtolower($name[rand(0, sizeof($name) - 1)]);
    }

    public static function fileName($id, $filename) {
            $fname = $id . '.' . $filename . '.xml';
        return $fname;
    }

}

?>
