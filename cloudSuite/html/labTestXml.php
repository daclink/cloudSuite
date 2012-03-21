<?php

$domDoc = new DOMDocument;
$lab = $domDoc->createElement('lab');
	$labID = $domDoc->createAttribute('id');
	$labIDVal = $domDoc->createTextNode('42');
	$labID->appendChild($labIDVal);
	$lab->appendChild($labID);
	
	$owner = $domDoc->createElement('owner');
	$owner->appendChild($domDoc->createTextNode('gotcha!'));
	$lab->appendChild($owner);


$rootNode = $domDoc->appendChild($lab);
echo $domDoc->saveXML(); 

?>
