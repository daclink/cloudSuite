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
if(!isset($_SESSION)) {
    session_start();
}



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
/*
 * Used to add a module to a lab in the main screen
 */
if(isset($_GET['addModuleToLab'])){
    $filename = $_ENV['cs']['labs_dir'].$_GET['addModuleToLab'];
    //print_r($_GET);
    $lab = Lab::loadLab($filename);
    
    //$lab = new Lab($owner, $id, $labName, $description, $xml);
    
    $module = Module::loadModule($_GET['moduleToLoad']);
    //print_r($module);
    try{
        $lab->addModule($module->getSimpleXML());
        $lab->writeLab();
    } catch (Exception $e){
               //$foo = $e->getMessage();
        echo "console.log(alert(\"There was a problem adding the module! " +$foo +"\"))";
        echo Utils::formatLab($lab);
        return false;
    }
    
   // $_SESSION['cs']['labFileName'] = $filename;
    
    echo Utils::formatLab($lab);
}

if (isset($_GET['newModule'])){
    
    $_ENV['cs']['debug'] = TRUE;
    print_r($_GET);
     $module = new Module('Drew', 'data', NULL, NULL, (String)$_GET['modName']);
     
     //$desc = Collection::getDesc($_GET['xmlScheme'], $_GET['xmlFile']);
     
     //$desc = Collection::getDesc($xmlScheme, $xmlFile);
     
      $xmlSchema = $_ENV['cs']['schema_dir']."lab.xsd";
      $xmlFile =  $_ENV['cs']['labs_dir']."4358.book.xml";
        
      $lab = Lab::loadLab($xmlFile);
      //$xmlFile =  $_ENV['cs']['labs_dir']. $lab->getFileName();
      //$xmlFile =  $_ENV['cs']['labs_dir']. '3872.han.xml';
      
      /*if (Utils::validate($xmlSchema, TRUE, $lab->getSimpleXML())){
          echo "<div>it' good!</div>";
      } else {
          echo "<div>damn!</div>";
      }*/
      
     // $lab->writeLab();
      
      //$lab->writeLab();
      //$lab = Lab::loadLab($xmlFile);
      $lab->addModule($module->getSimpleXML());
      
      $modules = $lab->getModules();
      
      print_r($modules);
      
      if (! $lab->writeLab()) {
          return false;
      }
      
     /*
     echo "<pre>";
     echo $desc[0][0];
     print_r($module);
     print_r($lab);
     echo "</pre>";*/
     
}

if (isset($_GET['listLab'])){
    //echo $_GET['listLab'];
    $labs =  Utils::returnFiles($_ENV['cs']['labs_dir']);
    if(isset($_SESSION['cs']['username'])){
        $uname = $_SESSION['cs']['username'];
        natcasesort($labs);
        foreach ($labs as $lab) {
            $labFile = Lab::loadLab($_ENV['cs']['labs_dir'] . $lab);
            $xml = $labFile->getSimpleXML();
            $owner = $xml->owner;
            
            if ($owner == $uname) {
                $parts = explode(".", $lab);

                $desc = "Labname : " . $xml['labName'] . " <br/> ";
                $desc = $desc . "Description : " . (String) $xml->description . "<br/>";
                $desc = $desc . "ID : " . $parts[0];

                echo "<script>var $parts[0] = $lab </script>";
                echo"<div id=\"$parts[0]\" class=\"labChoice lab-content csshadow chiClick\" name=\"$lab\" onclick=\"loadLabReturnNormal('$parts[0]','$parts[1]')\">$desc</div>";
            }
        }
     } else {
            echo "<div class=\"labChoice lab-content csshadow chiClick\" name='nullLab' onclick=\"loadLabReturnNormal()\">You must be logged in to load a lab.</div>";
            return false;
        }
}

if (isset($_GET['loadLabByFileName'])){
    $filename = $_ENV['cs']['labs_dir'].$_GET['loadLabByFileName'];
    
    $lab = Lab::loadLab($filename);
    
    $_SESSION['cs']['labFileName'] = $filename;
  /*  $lab = $lab->getSimpleXML();
    $labname = $lab['labName'];
    
    
    $return = "<span style=\"text-align:center;\">\n";
    $return = $return . "\t<h2>". $labname ."</h2>\n";
    $return = $return . "</span>\n";
    foreach ($lab->module as $module) {
        $return = $return . "<div class=\"lab-content csshadow\">";
        $return = $return . $module['moduleName'];
        $return = $return . "</div>\n"; 
    }
    
    echo $return; */
    
    echo Utils::formatLab($lab);
    
}

if (isset($_GET['loginUname'])){
    $creds = User::login("Drew");
    
    $_ENV['cs']['debug'] = TRUE;
    
    Utils::showStuff($creds, "credentials yo!");
    Utils::showStuff(SID, "Session ID? maybe?" );
}

if (isset($_GET['logout'])){

    User::logout();
}

if (isset($_GET['newLab'])){
    
    $owner= $_SESSION['cs']['username'];
    $id=NULL;
    $labName = $_GET['newLab'];
    
    if (isset($_GET['labDesc'])) {
        $description = $_GET['labDesc'];
    } else {
        echo "FAIL!";
        //echo "<script>alert(\"Must supply a description\");</script>";
        return false;
    }
    
    $lab = new Lab($owner, $id, $labName, $description);
    
    $lab->writeLab();
    
    echo Utils::formatLab($lab);
    
}

if (isset($_GET['saveLab'])){
    $filename = $_ENV['cs']['labs_dir'].$_GET['saveLab']; 
    try{
        $lab = Lab::loadLab($filename);
        $success = $lab->writeLab();
    } catch (Exception $e){
        echo "failed to save lab";
        return false;
    }
    
    echo $success;
}


if (isset($_GET['getModProperties']) && isset($_GET['create'])){
    
    //$filename = $_ENV['cs']['labs_dir'].$_GET['labToLoad'];
    //print_r($_GET);
    //$lab = Lab::loadLab($filename);
    
    //$lab = new Lab($owner, $id, $labName, $description, $xml);
    
    $module = Module::loadModule($_GET['modToLoad']);
    //print_r($module);
    /*try{
        $lab->addModule($module->getSimpleXML());
        $lab->writeLab();
    } catch (Exception $e){
               //$foo = $e->getMessage();
        echo "console.log(alert(\"There was a problem adding the module! " +$foo +"\"))";
        echo Utils::formatLab($lab);
        return false;
    }*/
    
   // $_SESSION['cs']['labFileName'] = $filename;
    
  //  echo Utils::formatLab($lab);
    //add error check
 
    echo Module::getModuleForm($_GET['modToLoad'],NULL,$_GET['labFileName']);
    
}


?>
