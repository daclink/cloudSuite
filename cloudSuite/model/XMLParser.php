<?php

$doc = new DOMDocument();
/*
  #$data = '<?xml version="1.0"?><foo/>';

  #$doc->loadXML($data);
 */

$doc->load('manifest.xml');

if ($doc->schemaValidate('manifest.xsd')) {
    echo 'hey! it worked!';
} else {
    echo 'well damn.';
    return;
}

if ($doc->loadXML('manifest.xml')) {
    $nodes = $doc->getElementById('node_name');
    foreach($nodes as $node) {
    }
}
?>
