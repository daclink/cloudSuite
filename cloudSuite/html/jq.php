<?php
/*%******************************************************************************************%*/
// CORE DEPENDENCIES

// Look for include file in the same directory (e.g. `./config.inc.php`).
if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php'))
{
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php';
}
// Fallback to `~/.aws/sdk/config.inc.php`
//TODO: Chnage this to a set of configuration defaults.
/*
elseif (getenv('HOME') && file_exists(getenv('HOME') . DIRECTORY_SEPARATOR . '.aws' . DIRECTORY_SEPARATOR . 'sdk' . DIRECTORY_SEPARATOR . 'config.inc.php'))
{
	include_once getenv('HOME') . DIRECTORY_SEPARATOR . '.aws' . DIRECTORY_SEPARATOR . 'sdk' . DIRECTORY_SEPARATOR . 'config.inc.php';
}
*/

/*%******************************************************************************************%*/

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cs' . DIRECTORY_SEPARATOR . 'cloudsuite.class.php';
?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title>Jquery!</title>
        <link type="text/css" href="theme/css/blitzer/jquery-ui-1.8.18.custom.css" rel="stylesheet" />
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="./theme/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="./theme/js/jquery-ui-1.8.18.custom.min.js"></script>
        
        <script type="text/javascript">
          $(function(){
        	// Tabs
		$('#tabs').tabs();
                $("#collections").accordion({ header: "h3" });
            });
        </script>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style type="text/css">
            #collections {width: 25%;}
        </style>
    </head>
    <body>
        <?php
        $xmlSchema = $_ENV['cs']['schema_dir']."module.xsd";
        $xmlFile =  $_ENV['cs']['module_dir']."hash_crack.233.xml";
        /*$lab = new Lab("gabbo");
        
        print_r($lab->listModules());
        
        $lab->writeLab();
        */
        Module::loadModule($xmlSchema, $xmlFile);
        
        ?>
    </body>
</html>
