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
        
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon"/>
        <link type="text/css" href="theme/css/blitzer/jquery-ui-1.8.18.custom.css" rel="stylesheet" />
        <link type="text/css" href="./styles/main.css" rel="stylesheet" />
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="./theme/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="./theme/js/jquery-ui-1.8.18.custom.min.js"></script>
        
        <script type="text/javascript">
          $(function(){
        	// Tabs
		$('#tabs').tabs();
                $("#collections").accordion({ header: "h3" });
            });
            
            $(document).ready(function() {
                $('#hide1').click(function(){
                    $('div.hider').hide();
                })
            });
        </script>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <style type="text/css">
            #collections {width: 25%;}
        </style>
    </head>
    <body>
        
        <button id="hideButton" class="hide1"> click to hide</button>
        <div id="hider">Well?</div>
        
        <?php
        $xmlSchema = $_ENV['cs']['schema_dir']."module.xsd";
        $xmlFile =  $_ENV['cs']['module_dir']."hash_crack.233.xml";
        /*$lab = new Lab("gabbo");
        
        print_r($lab->listModules());
        
        $lab->writeLab();
        */
      //  Lab::runAllLabs();
        //Module::loadModule($xmlSchema, $xmlFile);
        
        $labs = Utils::returnFiles('labs');
        $moduleT;
        $xmlSchema = $_ENV['cs']['schema_dir']."lab.xsd";
        $xmlFile =  $_ENV['cs']['labs_dir'].$labs[0];
        
        $lab = Lab::loadLab($xmlFile, $xmlSchema);
        
        $labXML = $lab->getLab();
        
        $modules = $labXML->module;
        echo "<pre>";
        echo "<h2>hi!</h2>";
        foreach ($modules as $module) {
            
            if ($module->seqNumber == '3') {
               $id = $module['id'];
               
               print_r($module);
              if (! $lab->addModule($module, NULL, NULL, '5')){
                  echo "Error!";
              }
              
            }
        }
        
        
        echo "</pre>";
        
        echo $id;
        
        //$lab->addModule($labXML->module->seq, $xmlFile, $xmlSchema, $seqNumber)
        
        //$newMod->seqNumber = 4;
        //$newMod['id'] = Utils::genID();
        
        $name = Utils::randomName();
        //$lab->setFileName($name);
        Utils::showStuff($lab->getFileName(), "FILENAME");
        
        $fileDir = $_ENV['cs']['labs_dir'];
        $filename = '240.gabbo.xml'; //$lab->getFileName();
       // $xml = $lab->asXML();
        Utils::fileWrite($labXML, $fileDir, $filename);
        
       // echo $lab->writeLab();
        echo "<h1> $name </h1>";
       ?><pre>
        <?php
        $name = Utils::randomName();
        //print_r($lab);
        //print_r($lab->module[1]);
        echo "<h1> $name </h1>";
        
        ?>
       </pre>
        <script>
               $(document).ready(function() {
                $('#hide1').click(function(){
                    $('div.hider').hide();
                })
            });
        
        </script>
        
    </body>
</html>
