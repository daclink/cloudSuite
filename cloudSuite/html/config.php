<?php

/*
 * CloudSuite Configuration file.
 * This file is used to set enviromental variables.
 */
   $__ROOT = "/home/drew/sites/cloudsuite.info/html/";
 $_ENV['cs']['manifest_dir'] = $__ROOT . 'manifest'.DIRECTORY_SEPARATOR;
 $_ENV['cs']['labs_dir'] = $__ROOT . 'labs'.DIRECTORY_SEPARATOR;
 $_ENV['cs']['schema_dir'] = $__ROOT . 'schema'.DIRECTORY_SEPARATOR; 
 $_ENV['cs']['collection_dir'] = $__ROOT . 'collections'.DIRECTORY_SEPARATOR;
 $_ENV['cs']['module_dir'] = $__ROOT . 'modules'.DIRECTORY_SEPARATOR;
 $_ENV['cs']['css'] = $__ROOT . 'script' .DIRECTORY_SEPARATOR;
 
 $_ENV['cs']['datawarehouse'] = 'cloudsuite.data.warehouse';
 
 $_ENV['cs']['groupFile'] = 'cloudsuite.info/group'.DIRECTORY_SEPARATOR ."group.xml";
 
//Clearance level required to delete
 $_ENV['cs']['DEL_LEVEL'] = 10;
 
 $_ENV['cs']['debug'] = FALSE;
 
 date_default_timezone_set('America/Los_Angeles');
 
 $_ENV['cs']['aws']['credntials'] = array();
 //$_ENV['cs']['aws']['region'] = 
 
?>
