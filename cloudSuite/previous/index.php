<?php namespace view;
//include_once 'control/cloud.controller.php';
include 'cs\cloudsuite.php';
 

    $scheme = '\model\manifest.xsd';
    $file = '\model\manifest.xml';
    
    if (\cs\moduleValidator::validate($scheme, $file)){
        echo 'good!';
    } else {
        echo 'bad';
    }
////$csmoduleValidator::($scheme,$file);

?>
