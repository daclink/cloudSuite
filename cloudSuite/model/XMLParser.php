<?php
$doc = new DOMDocument();

$data = '<?xml version="1.0"?><foo/>';

$doc->loadXML($data);

$doc->load('manifest.xml');

if ($doc->schemaValidate('manifest.xsd')) {
    echo 'hey! it worked!';
} else {
    echo 'well damn.';
}
?>
