<?php

namespace CSModel;

/**
 * This file represents the MODEL of MVC
 * it will be used to parse, create, save,
 * and modify XML data stores.
 */
class Utils {

    public function readXML($XML_file) {

        $doc = new DOMDocument();
        /*
          #$data = '<?xml version="1.0"?><foo/>';

          #$doc->loadXML($data);
         */
        //TODO:Check that file exists.
        $doc->load($XML_file);

        if ($doc->schemaValidate($XML_file)) {
            echo 'hey! it worked!';
        } else {
            echo 'well damn.';
            return;
        }

        if ($doc->loadXML($XML_file)) {
            $nodes = $doc->getElementById('node_name');
            foreach ($nodes as $node) {
                
            }
        }
    }

}

?>
