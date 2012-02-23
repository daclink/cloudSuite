<?php

/*
 */

/**
 * Description of cloudsuite
 *
 * @author drew
 */
if (file_exists(dirname(__FILE__) .
                DIRECTORY_SEPARATOR . 'config.php')) {
    include_once dirname(__FILE__) .
            DIRECTORY_SEPARATOR . 'config.php';
                }


/**
 * CloudSuite: Class include files.
 * 
 */

	include_once('collection.class.php');
	include_once('exceptions.class.php');
	include_once('lab.class.php');
	include_once('module.class.php');
	include_once('user.class.php');
	include_once('utils.class.php');


?>
