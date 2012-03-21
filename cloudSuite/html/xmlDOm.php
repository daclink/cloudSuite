<?php


$domDoc = new DOMDocument;
$rootElt = $domDoc->createElement('root');
$rootNode = $domDoc->appendChild($rootElt);

$subElt = $domDoc->createElement('foo');
    $attr = $domDoc->createAttribute('ah');
    $attrVal = $domDoc->createTextNode('OK');
    $attr->appendChild($attrVal);
    $subElt->appendChild($attr);
$subNode = $rootNode->appendChild($subElt);

$textNode = $domDoc->createTextNode('Wow, it works!');
$subNode->appendChild($textNode);

//echo htmlentities($domDoc->saveXML());
echo $domDoc->saveXML();

?>
