<?php

/*
 * CloudSuite Configuration file.
 * This file is used to set enviromental variables.
 */
 $_ENV['cs']['manifest_dir'] = 'manifest'.DIRECTORY_SEPARATOR;
 $_ENV['cs']['labs_dir'] = 'labs'.DIRECTORY_SEPARATOR;
 $_ENV['cs']['schema_dir'] = 'schema'.DIRECTORY_SEPARATOR; 
 $_ENV['cs']['collection_dir'] = 'collections'.DIRECTORY_SEPARATOR;
 $_ENV['cs']['module_dir'] = 'modules'.DIRECTORY_SEPARATOR;
 $_ENV['cs']['css'] = 'script' .DIRECTORY_SEPARATOR;
 
 $_ENV['cs']['groupFile'] = 'group'.DIRECTORY_SEPARATOR ."group.xml";
 
//Clearance level required to delete
 $_ENV['cs']['DEL_LEVEL'] = 10;
 
 $_ENV['cs']['debug'] = FALSE;
 

 date_default_timezone_set('America/Los_Angeles');
 
?>
