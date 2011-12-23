<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


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
<html>
    <head>
        <title>CloudSuite</title>
    </head>
    <body>
        <h1>it begins.</h1>
        <div>
            <?php $blah = new CloudSuite();
                
            ?>
        </div>
        <div>
            <?php
                $xmlFile = $_ENV['cs']['set_dir'].'biological.xml';
                $xmlScheme = $_ENV['cs']['schema_dir'].'set.xsd';
                
                
                
                echo "<div> File is $xmlFile</div>";
                echo "<div> scheme is $xmlScheme</div>";
                
               if( CloudSuite::validate($xmlScheme, $xmlFile)) {
                echo "<div>IT'S GOOD!</div>";
                
                 $set = new set($xmlScheme, $xmlFile);
                 
                 echo "<pre>";
                 $foo = set::listModules($xmlScheme, $xmlFile);
                    
                 print_r($foo);
//$set->listModules();
                 echo "</pre>";
                
                 //module::listAllModules($xmlFile);
                
                
               } else {
                  echo "<div>IT'S not valid but good!!</div>";
               }
               
               
               
               
               ?>
        </div>
    </body>
</html>
