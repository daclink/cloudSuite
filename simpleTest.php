<?php

$foo = new SimpleXMLElement('<lab></lab>');
$bar = $foo->addChild('bar','none');

$foo->addAttribute('cake','true');

echo "\nbefore unset\n";

echo $foo->asXML();

echo "\nafter unset\n";
unset($foo->bar);
echo $foo->asXML();
?>
