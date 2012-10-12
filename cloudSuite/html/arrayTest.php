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
/*
$mod = new Module(Null,Null);

$parms = array('flag' => '-t', 
               'value' =>'text',
               'description' =>'returns a text file',
               'required' =>'false',
               'dataType' =>'text',
               'default' => 'false',
               'exclusive' => array('-T','-F','-r'),
               'output' =>'text file');

$mod->addParam($parms);
*/
//echo json_encode($mod->listParamters());
//Utils::showStuff(json_encode($mod->listParamters()));

//return $mod->listParamters();

?>
<html>
    <head>
        <title>formTest</title>
    </head>
    <body>
        <input type="checkbox" checked="yes" value="cake" name="desserts[]" >cake</input>
        <input type="checkbox" checked="no" value="pie" name="desserts[]" />
        <input type="checkbox" checked value="brownie" name="desserts[]" />
        <input type="checkbox"  value="cookie" name="desserts[]" />
    </body>
</html>