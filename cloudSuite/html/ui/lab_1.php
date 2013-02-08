<?php

/* %******************************************************************************************% */
// CORE DEPENDENCIES
// Look for include file in the same directory (e.g. `./config.inc.php`).

if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config.php')) {
    include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config.php';
}
// Fallback to `~/.aws/sdk/config.inc.php`
//TODO: Chnage this to a set of configuration defaults.
/*
  elseif (getenv('HOME') && file_exists(getenv('HOME') . DIRECTORY_SEPARATOR . '.aws' . DIRECTORY_SEPARATOR . 'sdk' . DIRECTORY_SEPARATOR . 'config.inc.php'))
  {
  include_once getenv('HOME') . DIRECTORY_SEPARATOR . '.aws' . DIRECTORY_SEPARATOR . 'sdk' . DIRECTORY_SEPARATOR . 'config.inc.php';
  }
 */

/* %******************************************************************************************% */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cs' . DIRECTORY_SEPARATOR . 'cloudsuite.class.php';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'aws' . DIRECTORY_SEPARATOR . 'sdk-1.5.15' . DIRECTORY_SEPARATOR . 'sdk.class.php';
?>
<span style="text-align:center;"><h2>Collections</h2></span>
<?php

$xmlScheme = $_ENV['cs']['schema_dir'] . 'collection.xsd';

if ($handle = opendir($_ENV['cs']['collection_dir'])) {
    // echo "\nDir handle : $handle";
    // $divList = "";
    // echo "<ul>";
    while (false !== ($entry = readdir($handle))) {
        if ($entry != '.' && $entry != '..') {

            $parts = explode(".", $entry);

            $xmlFile = $_ENV['cs']['collection_dir'] . $entry;
            $desc = Collection::getDesc($xmlScheme, $xmlFile);
            $modules = Collection::listModules($xmlScheme, $xmlFile);

            echo "<div class='collection-list'>";
            echo "<h2>$parts[1]</h2>";
            //echo "<div class='module-list'>";//div 2
            echo "<div>"; //div 2
            echo $desc[0];
            echo "<div class='coll-mods'>"; //div3
            foreach ($modules as $module) {

                $key = $module['id'];
                $value = $module->desc;
                //echo "<div id=\"".$module['id']."\" ><h4>$module->desc</h4>";
                // foreach($module->fieldset as $fieldset){
                $xmlFile = $_ENV['cs']['module_dir'] . Utils::fileName($module['id'], $module['name']);
                // echo  Module::getModuleForm($xmlFile);
                //}
                //echo "</div>";
                echo "<div id=\"" . $key . "_link\" class=\"chiClick csshadow module\" onclick=\"getModToAdd('$xmlFile')\">" . $module['name'] . " </div>";
                //<a href=\"#\" id=\"".$key."_link\" class=\"ui_state-default ui-corner-all\"></a>
            }
            echo "</div>"; //div3 coll-mods
            echo "</div>"; //div2 module-list
            echo "</div>"; //div 1 collection-list
        }
    }

    closedir($handle);
    //echo "</ul>";
    //echo $divList;
}
if (isset($_SESSION['cs']['username']) || isset($_GET['uname'])) {

    $uname = isset($_SESSION['cs']['username']) ? $_SESSION['cs']['username'] : $_GET['uname'];
    $s3 = new AmazonS3(array(
                'key' => 'AKIAI4HYP3G5GQ2CG7MQ',
                'secret' => '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'
            ));

    $bucket = "cs.user.$uname.modules";
    $bucket = strtolower($bucket);
    if (!$s3->if_bucket_exists($bucket)) {
        $s3->create_bucket($bucket, AmazonS3::REGION_US_E1);
    }
 
    $response = $s3->get_object_list($bucket);

    echo "<div class='collection-list'>";
    echo "<h2> $uname's Modules</h2>";
    echo "<div class='module-list'>"; //div 2
    //echo $desc[0];
    echo "Modules that have been created by $uname";
    echo "<div class='coll-mods'>"; //div3
    foreach($response as $key => $value) {
        
        $module = new SimpleXMLElement($s3->get_object($bucket, $value)->body);
        $id = $module['id'];
        //full path to the module.
        $xmlFile = $_ENV['cs']['module_dir'] . $value;
                echo "<div id=\"" . $key . "_link\" class=\"chiClick csshadow module\" onclick=\"getModToAdd('$xmlFile')\">" . $module['name'] . " </div>";
        
    }
 
    echo "</div>"; //div3 coll-mods
    echo "</div>"; //div2 module-list
    echo "</div>"; //div 1 collection-list
}
?>