<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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


if (isset($_GET['listModule'])){
    
     $mods = Collection::listModules($_GET['xmlScheme'], $_GET['xmlFile']);
        foreach($mods as $key){
            echo "<div class=\"modList\" id=\"$key\">";
            echo $value;
            echo "</div>";
        }
     
}
if (isset($_GET['colGetModID'])){
    
     $module = Collection::getModuleByID($_GET['xmlScheme'], $_GET['xmlFile'], $_GET['modid']);
     
     echo "<pre>";
     print_r($module);
     echo "</pre>";
     
     $_GET['FOO']= $module;
     
}
if (isset($_GET['colGetDesc'])){
    
     //$xmlFile = $_ENV['cs']['collection_dir'].'biological.xml';
    // $xmlScheme = $_ENV['cs']['schema_dir'].'collection.xsd';
    
     $desc = Collection::getDesc($_GET['xmlScheme'], $_GET['xmlFile']);
     
     //$desc = Collection::getDesc($xmlScheme, $xmlFile);
     echo "<pre>";
     echo $desc[0][0];
    // print_r($desc);
     echo "</pre>";
     
}

if (isset($_GET['newModule'])){
    
    $_ENV['cs']['debug'] = TRUE;
    print_r($_GET);
     $module = new Module('Drew', 'data', NULL, NULL, (String)$_GET['modName']);
     
     //$desc = Collection::getDesc($_GET['xmlScheme'], $_GET['xmlFile']);
     
     //$desc = Collection::getDesc($xmlScheme, $xmlFile);
     
      $xmlSchema = $_ENV['cs']['schema_dir']."lab.xsd";
      $xmlFile =  $_ENV['cs']['labs_dir']."240.gabbo.xml";
        
      $lab = new Lab("Drew");
      $xmlFile =  $_ENV['cs']['labs_dir']. $lab->getFileName();
      //$xmlFile =  $_ENV['cs']['labs_dir']. '3872.han.xml';
      
      Utils::showStuff($xmlFile, 'file is');
      
      /*if (Utils::validate($xmlSchema, TRUE, $lab->getSimpleXML())){
          echo "<div>it' good!</div>";
      } else {
          echo "<div>damn!</div>";
      }*/
      
     // $lab->writeLab();
      
      $lab->writeLab();
      //$lab = Lab::loadLab($xmlFile);
      $lab->addModule($module->getSimpleXML());
      
      $modules = $lab->getModules();
      
      print_r($modules);
      
      $lab->writeLab();
      
     
     echo "<pre>";
     //echo $desc[0][0];
     //print_r($module);
     print_r($lab);
     echo "</pre>";
     
}

?>
