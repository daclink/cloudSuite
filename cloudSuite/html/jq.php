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
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        
        <?php $foo = "hoi!"?>  
        <div id="module"></div>
        <div id="time"></div>
        <div id="all"></div>
        <button>Get module!</button>
        <script type="text/javascript">
         <?php
             $xmlFile = $_ENV['cs']['collection_dir'].'biological.xml';
             $xmlScheme = $_ENV['cs']['schema_dir'].'collection.xsd';
         ?>
            
            
            
            $(document).ready(function(){
                $("button").click(function(){
                $("#module").load('./rest.php?listModule=true&xmlScheme=<?echo $xmlScheme?>&xmlFile=<?echo $xmlFile?>');
                
                
                });
            });
            
             $("div.modList").live('click', function() {
                var id = this.id;
                alert("woo " + id) });
             
        </script>
        <?php
        $mod = new Module(Null,Null);

        $parms = array('flag' => '-t', 
               'value' =>'text',
               'description' =>'returns a text file',
               'required' =>'false',
               'dataType' =>'text',
               'default' => 'false',
               'exclusive' => array('-T','-F','-r'),
               'output' =>'text file',
               'input' => '');
        
        $mod->addParam($parms);
        
        $parms = array('flag' => '-V', 
               'value' =>'',
               'description' =>'Verbose output',
               'required' =>'false',
               'dataType' =>'n/a',
               'default' => 'false',
               'exclusive' => array(),
               'output' =>'N/A',
               'input' => '');
        $mod->addParam($parms);
        
        Utils::showStuff($mod->listParamters());
        ?>
        
    </body>
</html>
